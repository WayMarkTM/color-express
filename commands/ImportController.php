<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 5/30/2017
 * Time: 8:22 PM
 */

namespace app\commands;


use app\services\ImportService;
use yii\console\Controller;

class ImportController extends Controller
{
    /**
     * @var ImportService
     */
    private $importService;

    public function init()
    {
        $this->importService = new ImportService();
        parent::init();
    }

    public function actionUpdateBalance() {
        echo "Starting update client balance...\n";
        if ($this->importService->updateBalance()) {
            echo "Finished updating client balance. \n";
        } else {
            echo "Updating client balance failed.";
        }
    }

}