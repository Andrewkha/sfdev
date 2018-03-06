<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/6/2018
 * Time: 12:54 PM
 */

namespace core\forms\auth;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин или email',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня',
        ];
    }
}