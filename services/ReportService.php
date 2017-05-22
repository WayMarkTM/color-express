<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 22.05.2017
 * Time: 19:48
 */

namespace app\services;

use app\models\User;

class ReportService
{
    /**
     * @return object Excel Response
     */
    public function getReport() {
        $file = \Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'sheets' => [
                'Users' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => User::find(),
                ]
            ]
        ]);

        return $file;
    }
}