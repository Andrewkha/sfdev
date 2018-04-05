<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/5/2018
 * Time: 1:46 PM
 */

namespace core\services\TeamStandings\calculator;


use core\entities\sf\Game;

class PlayoffGameCalculator implements GameCalculatorInterface
{
    /*
 * Assigning +2 point for win in play off stage - tour > 3
 */
    const RESULT_DRAW = 1;
    const RESULT_WIN = 3;
    const RESULT_LOSE = 0;

    const RESULT_PLAY_OFF_ADDITIONAL = 2;

    public function assignGamePoints(Game &$game)
    {
        if ($game->homeScore === NULL || $game->guestScore === NULL) {
            $pointsHome = NULL;
            $pointsGuest = NULL;
        } elseif ($game->homeScore > $game->guestScore) {
            $pointsHome = self::RESULT_WIN;
            if ($game->tour > 3) {
                $pointsHome += self::RESULT_PLAY_OFF_ADDITIONAL;
            }
            $pointsGuest = self::RESULT_LOSE;
        } elseif ($game->homeScore === $game->guestScore) {
            $pointsHome = self::RESULT_DRAW;
            $pointsGuest = self::RESULT_DRAW;
        } else {
            $pointsHome = self::RESULT_LOSE;
            $pointsGuest = self::RESULT_WIN;
            if ($game->tour > 3) {
                $pointsGuest += self::RESULT_PLAY_OFF_ADDITIONAL;
            }
        }

        $game->assignPoints($pointsHome, $pointsGuest);
    }
}