<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/28/2018
 * Time: 3:46 PM
 */

namespace core\validators;


use yii\validators\RegularExpressionValidator;

class SlugValidator extends RegularExpressionValidator
{
    public $pattern = '#^[a-z0-9_-]*$#s';
    public $message = 'Неверный формат';
}