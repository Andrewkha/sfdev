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
    public static function countryList()
    {
        return ArrayHelper::map(Country::find()->all(), 'id', 'name');
    }

    public static function countryListWithTournaments()
    {
        return ArrayHelper::map(Country::find()->joinWith('tournaments t', false)
            ->where(['not', ['t.id' => null]])
            ->all(), 'id', 'name');
    }
}