<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $phone;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'body'], 'required'],
            [['name', 'phone'], 'string', 'max' => 100],
            ['body', 'string', 'max' => 2000],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Введите символы, изображенные на картинке',
            'name' => 'Ваше имя',
            'phone' => 'Номер телефона',
            'body' => 'Ваше сообщение (до 2000 символов)'
        ];
    }
}
