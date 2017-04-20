<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/17/2017
 * Time: 8:22 PM
 */

namespace app\models;

use yii\base\Model;

class AddSubclientForm extends Model
{
    public $name;
    public $userId;

    public function rules()
    {
        return [
            [['name'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название компании-субклиента'
        ];
    }
}