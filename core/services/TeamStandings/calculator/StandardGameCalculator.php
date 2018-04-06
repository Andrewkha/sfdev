<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/5/2018
 * Time: 1:32 PM
 */

namespace core\services\TeamStandings\calculator;


use core\entities\sf\Game;

class StandardGameCalculator implements GameCalculatorInterface
{
    const RESULT_DRAW = 1;
    const RESULT_WIN = 3;
    const RESULT_LOSE = 0;

    public function assignGamePoints(Game &$game)
    {

        if ($game->homeScore === NULL || $game->guestScore === NULL) {
            $pointsHome = NULL;
            $pointsGuest = NULL;
        } elseif ($game->homeScore > $game->guestScore) {
            $pointsHome = self::RESULT_WIN;
            $pointsGuest = self::RESULT_LOSE;
        } elseif ($game->homeScore === $game->guestScore) {
            $pointsHome = self::RESULT_DRAW;
            $pointsGuest = self::RESULT_DRAW;
        } else {
            $pointsHome = self::RESULT_LOSE;
            $pointsGuest = self::RESULT_WIN;
        }

        $game->assignPoints($pointsHome, $pointsGuest);
    }
}