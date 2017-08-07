<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 5/30/2017
 * Time: 8:27 PM
 */

namespace app\services;


use app\models\entities\ClientBalance;
use app\models\entities\ImportFile;
use app\models\User;
use Yii;
use yii\db\Exception;

class ImportFileStatuses {
    const TO_PROCESS = 1;
    const PROCESSED = 2;
}

class ImportService
{
    public function updateBalance() {
        $lines = $this->getClientBalanceLines();
        if ($lines == null) {
            return false;
        }

        echo "\n--> Found csv lines: ".count($lines)."\n\n";
        if (!$this->updateClientBalance($lines)) {
            return false;
        }

        if (!$this->updateAgencyBalance($lines)) {
            return false;
        }

        $this->updateCsvStatus();

        return true;
    }

    private function updateCsvStatus() {
        $file = $this->getImportFile();
        $file->status = ImportFileStatuses::PROCESSED;
        $file->save();
    }

    private function updateAgencyBalance($lines) {
        $agencies = $this->getAgencies();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            echo "--> Found agencies: ".count($agencies)."\n";

            foreach ($agencies as $agency) {
                $agency->balance = 0;
                $usedContracts = array();
                foreach ($agency->subclients as $subclient) {
                    $subclient->balance = 0;
                    $subclientContracts = array();
                    foreach ($subclient->documents as $document) {
                        foreach ($lines as $line) {
                            if ($line->pan == $agency->pan && $line->contract != null && $document->contract == $line->contract) {
                                if (!in_array($line->contract, $subclientContracts)) {
                                    $subclient->balance += $line->amount;
                                    array_push($subclientContracts, $line->contract);

                                    if (!in_array($line->contract, $usedContracts)) {
                                        $agency->balance += $line->amount;
                                        array_push($usedContracts, $line->contract);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            foreach ($agencies as $agency) {
                $agency->save();

                foreach ($agency->subclients as $subclient) {
                    $subclient->save();
                }
            }

            $transaction->commit();
            return true;
        }
        catch (Exception $exc) {
            $transaction->rollBack();
            echo $exc->getMessage();
            return false;
        }
    }

    private function updateClientBalance($lines) {
        $clients = $this->getClients();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            echo "--> Found clients: ".count($clients)."\n";
            foreach ($clients as $client) {
                $client->balance = 0;
                foreach ($client->documents as $document) {
                    foreach ($lines as $line) {
                        if ($document->contract != null && $line->contract != null && $document->contract == $line->contract) {
                            $client->balance += $line->amount;
                        }
                    }
                }

                $client->save();
            }

            $transaction->commit();
            return true;
        }
        catch (Exception $exc) {
            $transaction->rollBack();
            echo $exc->getMessage();
            return false;
        }
    }

    /**
     * @return array|ClientBalance[]
     */
    private function getClientBalanceLines() {
        $file = $this->getImportFile();

        if ($file == null) {
            echo "\n\n---- No CSV found\n\n";
            return null;
        }

        return $file->clientBalances;
    }

    /**
     * @return ImportFile
     */
    private function getImportFile() {
        return ImportFile::find()
            ->where(['>', 'created_at', (new \DateTime())->format('Y-m-d')])
            ->andWhere(['=', 'status', ImportFileStatuses::TO_PROCESS])
            ->one();
    }

    /**
     * @return array|User[]
     */
    private function getClients() {
        return User::find()
            ->where(['is not', 'manage_id', null])
            ->andWhere(['=', 'is_agency', 0])
            ->all();
    }

    /**
     * @return array|User[]
     */
    private function getAgencies() {
        return User::find()
            ->where(['is not', 'manage_id', null])
            ->andWhere(['=', 'is_agency', 1])
            ->all();
    }
}