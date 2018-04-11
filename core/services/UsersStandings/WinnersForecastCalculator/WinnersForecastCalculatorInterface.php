<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/11/2018
 * Time: 2:49 PM
 */

namespace core\services\UsersStandings\WinnersForecastCalculator;

use core\entities\user\User;
use core\entities\sf\Tournament;

interface WinnersForecastCalculatorInterface
{
    public function assignForecastPoints(Tournament $tournament, User $user);
}