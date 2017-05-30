<?php

namespace importer;

use mysqli;

class Constants {
    const CSV_DIRECTORY = 'D:/import from 1c/csv/';
    const SERVER_NAME = '127.0.0.1';
    const DB_USERNAME = 'root';
    const DB_PASSWORD = '';
    const DB_NAME = 'colorexpressdev';
}

class ImportedFileStatuses {
    const DRAFT  = 0;
    const TO_PROCESS  = 1;
    const PROCESSED = 2;
}

class DataAccess {
    /**
     * @var mysqli
     */
    private $connection;

    public function saveCsvLines($fileId, $csv) {
        $this->openConnection();
        $this->connection->autocommit(false);
        echo "Saving csv ".$csv." rows into database...\n";

        $filepath = Constants::CSV_DIRECTORY.$csv;
        $query = <<<eof
    LOAD DATA INFILE '$filepath'
    INTO TABLE `client_balance`
    FIELDS TERMINATED BY ';'
    LINES TERMINATED BY '\r\n'
    (@company,@pan,@contract,@amount)
    SET `company` = @company,
        `pan` = @pan,
        `contract` = @contract,
        `amount` = REPLACE(@amount, ',', '.'),
        `imported_from_id` = $fileId,
        `created_at` = NOW()
eof;

        $this->connection->query($query);

        echo "Updating import_file status... \n";

        $query = "UPDATE import_file SET status = ".ImportedFileStatuses::TO_PROCESS." WHERE id = ".$fileId;

        $this->connection->query($query);

        echo "Commiting transaction... \n";

        if ($this->connection->commit()) {
            echo "Import from " . $filepath . " successfully finished. \n";
        } else {
            echo $this->connection->error."\n\n";
        }

        $this->connection->autocommit(true);
        $this->closeConnection();
    }

    public function saveImportedFile($csv) {
        $id = null;
        $this->openConnection();

        echo "Saving csv ".$csv." into database...\n";
        $query = "INSERT INTO import_file(filename, status, created_at) VALUES ('".$csv."', ".ImportedFileStatuses::DRAFT.", NOW())";

        if ($this->connection->query($query)) {
            $id = $this->connection->insert_id;
            echo "File saved with id = ".$id."\n";
        } else {
            echo $this->connection->error."\n\n";
        }

        $this->closeConnection();

        return $id;
    }

    public function getImportedFiles() {
        $this->openConnection();
        echo "Getting list of imported files...";

        $sql = "SELECT filename FROM import_file WHERE status = ".ImportedFileStatuses::PROCESSED;
        $query = $this->connection->query($sql);
        $filenames = array();

        if ($query->num_rows > 0) {
            while($row = $query->fetch_assoc()) {
                array_push($filenames, $row['filename']);
            }
        }

        echo "Successfully got\n";
        $this->closeConnection();

        return $filenames;
    }

    private function openConnection() {
        $this->connection = new mysqli(Constants::SERVER_NAME, Constants::DB_USERNAME, Constants::DB_PASSWORD, Constants::DB_NAME);

        if ($this->connection->connect_error) {
            die("Connection failed:".$this->connection->connect_error);
        }
    }

    private function closeConnection() {
        $this->connection->close();
    }
}

class Importer {
    /**
     * @var DataAccess
     */
    private $dataAccess;

    public function __construct()
    {
        $this->dataAccess = new DataAccess();
    }

    public function run() {
        $csvs = $this->getNotProcessedFiles();
        $this->loadData($csvs);

        echo "Task successfully finished";
    }

    private function loadData($csvs) {
        foreach ($csvs as $csv) {
            $csvId = $this->dataAccess->saveImportedFile($csv);
            $this->dataAccess->saveCsvLines($csvId, $csv);
        }
    }

    private function getNotProcessedFiles() {
        $filesInDb = $this->dataAccess->getImportedFiles();
        $filesInFs = $this->getAllFilesInDirectory();

        $result = array();

        foreach ($filesInFs as $fsFile) {
            if (!in_array($fsFile, $filesInDb)) {
                array_push($result, $fsFile);
            }
        }

        return $result;
    }

    private function getAllFilesInDirectory() {
        $result = array();
        if ($handle = opendir(Constants::CSV_DIRECTORY)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    array_push($result, $entry);
                }
            }

            closedir($handle);
        } else {
            echo "Error while opening directory: ".Constants::CSV_DIRECTORY;
        }

        return $result;
    }
}

$importer = new Importer();
echo $importer->run();