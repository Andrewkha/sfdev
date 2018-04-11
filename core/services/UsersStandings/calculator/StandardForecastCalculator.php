<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/6/2018
 * Time: 3:56 PM
 */

namespace core\services\UsersStandings\calculator;


use core\entities\sf\Forecast;

class StandardForecastCalculator implements ForecastCalculatorInterface
{
    const FORECAST_FULL_MATCH = 3;
    const FORECAST_SCORE_DIFF = 2;
    const FORECAST_WINNER = 1;
    const FORECAST_NONE = 0;

    public function assignForecastPoints(Forecast &$forecast, $homeScore, $guestScore): void
    {
        if ($homeScore === NULL || $guestScore === NULL) {
            $forecast->assignPoints(NULL);
        }

        if ($forecast->isFullMatch($homeScore, $guestScore)) {
            $forecast->assignPoints(self::FORECAST_FULL_MATCH);
            return;
        }

        if ($forecast->isScoreDiff($homeScore, $guestScore)) {
            $forecast->assignPoints(self::FORECAST_SCORE_DIFF);
            return;
        }

        if ($forecast->isWinner($homeScore, $guestScore)) {
            $forecast->assignPoints(self::FORECAST_WINNER);
            return;
        }
        $forecast->assignPoints(self::FORECAST_NONE);
        return;
    }
}