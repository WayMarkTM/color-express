<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 11:18 PM
 */

namespace app\models;

use yii\base\Model;

class OrderItemModel extends Model
{

    public $id;
    public $advertisingConstructionName;
    public $address;
    public $type;
    public $status;
    public $dateFrom;
    public $dateTo;
    public $cost;


    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'advertisingConstructionName' => 'Название',
            'address' => 'Адрес',
            'cost' => 'Цена с НДС (бел. руб.)',
            'type' => 'Тип',
            'status' => 'Статус'
        ];
    }

}