<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 16.03.2017
 * Time: 19:35
 */

namespace app\models;


use yii\base\Model;

class SubmitCartForm extends Model
{
    public $thematic;

    public function rules()
    {
        return [
            [['thematic'], 'required'],
            [['thematic'], 'string']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'thematic' => 'Укажите, пожалуйста, тематику сюжета:'
        ];
    }
}