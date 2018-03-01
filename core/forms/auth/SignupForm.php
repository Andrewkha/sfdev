<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/22/2018
 * Time: 2:51 PM
 */

namespace core\forms\auth;

use himiklab\yii2\recaptcha\ReCaptchaValidator;
use yii\base\Model;
use yii\web\UploadedFile;
use core\entities\user\User;

/**
 * Class SignupForm
 * @package core\forms\auth
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $repeatPassword
 * @property string $firstName
 * @property string $lastName
 * @property UploadedFile $avatar
 * @property string $notification
 *
 */

class SignupForm extends Model
{
    public $username;
    public $password;
    public $repeatPassword;
    public $email;
    public $firstName;
    public $lastName;
    public $avatar;
    public $notification = true;

    public $reCaptcha;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Пользователь с таким именем уже существует'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email', 'message' => 'Введите корректный email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Пользователь с таким email уже существует'],

            [['password', 'repeatPassword'], 'required'],
            [['password', 'repeatPassword'], 'string', 'min' => 6, 'message' => 'Пароль не должен быть короче 6 символов'],

            ['repeatPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Введенные пароли не совпадают'],

            ['firstName', 'trim'],
            ['firstName', 'string', 'max' => 50],

            ['lastName', 'trim'],
            ['lastName', 'string', 'max' => 50],

            [['avatar'], 'image', 'maxSize' => 1024*1024, 'tooBig' => 'Максимальный размер файла 1Мб'],

            ['notification', 'boolean'],

            [['reCaptcha'], ReCaptchaValidator::class],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'repeatPassword' => 'Повторите пароль',
            'avatar' => 'Аватар',
            'firstName' => 'Имя',
            'lastName' => 'Фамилия',
            'notification' => 'Подписка на новости сайта',
            'verifyCode' => 'Введите символы с картинки'
        ];
    }
}