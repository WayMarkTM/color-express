<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 16.03.2017
 * Time: 19:35
 */

namespace app\models;


use app\models\entities\AdvertisingConstructionReservation;
use yii\base\Model;

/**
 * Class SubmitCartForm
 * @package app\models
 * @var $reservations array|AdvertisingConstructionReservation
 * @var $thematic string
 */
class SubmitCartForm extends Model
{
    public $thematic;
    public $reservations;

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