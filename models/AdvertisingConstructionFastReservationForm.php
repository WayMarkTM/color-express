<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 13.03.2017
 * Time: 17:01
 */

namespace app\models;


use yii\base\Model;

class AdvertisingConstructionFastReservationForm extends Model
{
    public $fromDate;
    public $toDate;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['fromDate', 'toDate'], 'required']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'fromDate' => 'с',
            'toDate' => 'по',
        ];
    }


}