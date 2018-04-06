<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/5/2018
 * Time: 1:23 PM
 */

namespace core\services\TeamStandings\calculator;


use core\entities\sf\Game;

interface GameCalculatorInterface
{
    public function assignGamePoints(Game &$game);
}