<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/13/2018
 * Time: 1:02 PM
 */

namespace core\forms;


use himiklab\yii2\recaptcha\ReCaptchaValidator;
use yii\base\Model;

class ContactForm extends Model
{
    public $username;
    public $email;
    public $subject;
    public $body;
    public $reCaptcha;

    public function rules()
    {
        return [
            [['username', 'email', 'subject', 'body'], 'required'],
            ['email', 'email'],

            [['reCaptcha'], ReCaptchaValidator::class],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Ваше имя',
            'email' => 'Email',
            'subject' => 'Тема сообщения',
            'body' => 'Текст сообщения',
            'reCaptcha' => ''
        ];
    }
}