<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 23.03.2018
 * Time: 14:38
 */

namespace core\helpers;


use core\entities\sf\Country;
use yii\helpers\ArrayHelper;

class CountryHelper
{
    public static function coutnryList()
    {
        return ArrayHelper::map(Country::find()->all(), 'id', 'name');
    }
}