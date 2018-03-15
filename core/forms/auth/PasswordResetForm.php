<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/7/2018
 * Time: 4:18 PM
 */

namespace core\forms\auth;


use yii\base\Model;

class PasswordResetForm extends Model
{
    public $password;
    public $repeatPassword;

    public function rules()
    {
        return [
            [['password', 'repeatPassword'], 'required'],
            ['password', 'string', 'min' => 6, 'message' => 'Пароль не должен быть короче 6 символов'],
            ['repeatPassword', 'string', 'min' => 6, 'message' => 'Пароль не должен быть короче 6 символов'],

            ['repeatPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Введенные пароли не совпадают'],
        ];
    }
}