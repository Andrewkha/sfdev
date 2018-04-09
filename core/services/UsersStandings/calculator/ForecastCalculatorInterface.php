<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/6/2018
 * Time: 3:55 PM
 */

namespace core\services\UsersStandings\calculator;


use core\entities\sf\Forecast;

interface ForecastCalculatorInterface
{
    public function assignForecastPoints(Forecast &$forecast, $homeScore, $guestScore): void;
}