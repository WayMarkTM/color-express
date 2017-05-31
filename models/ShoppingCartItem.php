<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 16.03.2017
 * Time: 19:43
 */

namespace app\models;

use yii\base\Model;

class ShoppingCartItem extends Model
{
    public $id;
    public $advertisingConstructionName;
    public $address;
    public $dateFrom;
    public $dateTo;
    public $cost;
    public $marketingType;


    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'advertisingConstructionName' => 'Название',
            'address' => 'Адрес',
            'cost' => 'Цена с НДС (BYN)',
            'marketingType' => 'Статус рекламы'
        ];
    }
}