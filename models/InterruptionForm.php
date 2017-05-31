<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 5/31/2017
 * Time: 2:02 AM
 */

namespace app\models;


use yii\base\Model;

class InterruptionForm extends Model
{
    public $toDate;
    public $id;
    public $cost;

    public function rules()
    {
        return [
            [['toDate', 'id', 'cost'], 'required'],
            [['cost'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'toDate' => 'Дата окончания',
            'cost' => 'Стоимость за период (BYN)'
        ];
    }
}