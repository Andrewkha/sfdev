<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/6/2018
 * Time: 4:32 PM
 */

namespace core\services\UsersStandings;
use core\entities\sf\Forecast;
use core\entities\sf\Game;
use core\entities\user\User;
use yii\data\ArrayDataProvider;

/**
 * Class ForecastStandingsItem
 * @package core\services\UsersStandings
 *
 * @property User $user
 * @property integer $points
 * @property integer $exactCount
 * @property integer $scoreDiffCount
 * @property integer $outcomeCount
 * @property integer $forecastCount
 * @property ForecastTour[] $forecastTours
 */

class ForecastStandingsItem
{
    public $user;
    public $points = 0;
    public $exactCount = 0;
    public $scoreDiffCount = 0;
    public $outcomeCount = 0;
    public $forecastCount = 0;

    public $forecastedWinners;
    public $forecastTours;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function setItem(Forecast $forecast = null, Game $game, bool $needGameDetails): void
    {
        if ($game->isFinished() && $forecast) {
            if ($forecast->isFullMatch($game->homeScore, $game->guestScore)) {
                $this->exactCount++;
            }

            if ($forecast->isScoreDiff($game->homeScore, $game->guestScore)) {
                $this->scoreDiffCount++;
            }

            if ($forecast->isWinner($game->homeScore, $game->guestScore)) {
                $this->outcomeCount++;
            }
            $this->forecastCount++;
            $this->points += $forecast->getPoints();
        }
        $forecastTour = $this->getForecastTours($game->tour);

        if ($needGameDetails) {
            if ($forecast) {
                $forecastTour->addGame($game->homeTeam->name,
                    $game->guestTeam->name,
                    $game->tour,
                    $game->date,
                    $game->homeScore,
                    $game->guestScore,
                    $forecast->homeFscore,
                    $forecast->guestFscore,
                    $forecast->getPoints()
                );
            } else {
                $forecastTour->addGame($game->homeTeam->name,
                    $game->guestTeam->name,
                    $game->tour,
                    $game->date,
                    $game->homeScore,
                    $game->guestScore,
                    null,
                    null,
                    null
                );
            }
        }
    }

    private function getForecastTours($tour): ForecastTour
    {
        if (isset($this->forecastTours[$tour])) {
            return $this->forecastTours[$tour];
        } else {
            $this->forecastTours[$tour] = new ForecastTour($tour);
            return $this->forecastTours[$tour];
        }
    }

    public function forecastToursDataProvider(): ArrayDataProvider
    {
        return new ArrayDataProvider([
            'allModels' => $this->forecastTours,
            'pagination' => false
        ]);
    }

    public function forecastedWinnersDataProvider(): ArrayDataProvider
    {
        return new ArrayDataProvider([
            'allModels' => $this->forecastedWinners,
            'pagination' => false
        ]);
    }
}