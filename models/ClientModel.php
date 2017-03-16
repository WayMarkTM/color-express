<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 11:57 PM
 */

namespace app\models;

use yii\base\Model;

class ClientModel extends Model
{
    public $id;
    public $company;
    public $name;
    public $phone;
    public $email;
    public $type;
    public $responsiblePerson;
    public $company_id;

    /**
     * ClientModel constructor.
     * @param integer $id
     * @param string $company
     * @param string $name
     * @param string $phone
     * @param string $email
     * @param string $type
     * @param string $responsiblePerson
     */
    function __construct($id, $company, $name, $phone, $email, $type, $responsiblePerson) {
        parent::__construct();

        $this->id = $id;
        $this->company = $company;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->type = $type;
        $this->responsiblePerson = $responsiblePerson;
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company' => 'Компания',
            'name' => 'ФИ',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'type' => 'Тип',
            'responsiblePerson' => 'Ответственный'
        ];
    }

}