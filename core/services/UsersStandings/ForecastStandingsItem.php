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

/**
 * Class ForecastStandingsItem
 * @package core\services\UsersStandings
 *
 * @property User $user
 * @property ForecastGameItem[] $forecastGamesItem
 * @property integer $points
 * @property integer $exactCount
 * @property integer $scoreDiffCount
 * @property integer $outcomeCount
 * @property integer $forecastCount;
 */

class ForecastStandingsItem
{
    public $user;
    public $points = 0;
    public $exactCount = 0;
    public $scoreDiffCount = 0;
    public $outcomeCount = 0;
    public $forecastCount = 0;

    public $forecastGameItems;

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

        if ($needGameDetails) {
            if ($forecast) {
                $this->forecastGameItems[$game->tour] = new ForecastGameItem(
                    $game->homeTeam->name,
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
                $this->forecastGameItems[$game->tour] = new ForecastGameItem(
                    $game->homeTeam->name,
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
}