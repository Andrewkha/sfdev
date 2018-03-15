<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/7/2018
 * Time: 2:30 PM
 */

namespace core\forms\auth;


use yii\base\Model;

class PasswordResetRequestForm extends Model
{
    public $identity;

    public function rules()
    {
        return [
            ['identity', 'string'],
            ['identity', 'trim'],
            ['identity', 'required'],
        ];
    }
}