<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/17/2017
 * Time: 2:18 AM
 */

namespace app\models;

use yii\base\Model;

class RegistrationRequestModel extends Model
{
    public $id;
    public $company;
    public $timestamp;
    public $type;

    /**
     * RegistrationRequestModel constructor.
     * @param integer $id
     * @param string $company
     * @param \DateTime $timestamp
     * @param string $type
     */
    function __construct($id, $company, $timestamp, $type) {
        parent::__construct();

        $this->id = $id;
        $this->company = $company;
        $this->timestamp = $timestamp;
        $this->type = $type;
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company' => 'Компания',
            'timestamp' => 'Время получения заявки',
            'type' => 'Тип',
        ];
    }
}