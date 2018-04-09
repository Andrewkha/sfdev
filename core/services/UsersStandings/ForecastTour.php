<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/9/2018
 * Time: 3:37 PM
 */

namespace core\services\UsersStandings;

/**
 * Class ForecastTour
 * @package core\services\UsersStandings
 *
 * @property integer $tour
 * @property integer $points
 * @property ForecastGameItem[] $forecastGamesItem
 */

class ForecastTour
{

    const FORECAST_STATUS_COMPLETE = 'complete';
    const FORECAST_STATUS_PARTIAL = 'partial';
    const FORECAST_STATUS_EMPTY = 'empty';

    public $tour;
    public $points = 0;
    public $forecastGamesItem;

    public function __construct($tour)
    {
        $this->tour = $tour;
    }

    public function addGame($homeTeam, $guestTeam, $tour, $date, $homeScore, $guestScore, $homeForecast, $guestForecast, $points)
    {
        $this->forecastGamesItem[] = new ForecastGameItem(
            $homeTeam,
            $guestTeam,
            $tour,
            $date,
            $homeScore,
            $guestScore,
            $homeForecast,
            $guestForecast,
            $points
        );

        $this->points += $points;
    }

    public function getTourForecastStatus(): string
    {
        $forecasted = 0;
        $games = count($this->forecastGamesItem);
        foreach ($this->forecastGamesItem as $gameItem) {
            if ($gameItem->isForecastSet()) {
                $forecasted++;
            }
        }

        if ($forecasted == 0) {
            return self::FORECAST_STATUS_EMPTY;
        } elseif ($forecasted < $games) {
             return self::FORECAST_STATUS_PARTIAL;
        } else {
            return self::FORECAST_STATUS_COMPLETE;
        }
    }

    public function isTourForecastComplete(): bool
    {
        return $this->getTourForecastStatus() === self::FORECAST_STATUS_COMPLETE;
    }

    public function isTourForecastPartial(): bool
    {
        return $this->getTourForecastStatus() === self::FORECAST_STATUS_PARTIAL;
    }

    public function isTourForecastEmpty(): bool
    {
        return $this->getTourForecastStatus() === self::FORECAST_STATUS_EMPTY;
    }
}