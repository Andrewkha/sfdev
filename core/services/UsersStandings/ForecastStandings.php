<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/6/2018
 * Time: 4:23 PM
 */

namespace core\services\UsersStandings;

use core\entities\sf\Tournament;
use core\entities\user\User;
use core\services\TeamStandings\Standings;
use core\services\UsersStandings\calculator\ForecastCalculator;
use core\services\UsersStandings\WinnersForecastCalculator\StandardWinnersForecastCalculator;
use yii\helpers\ArrayHelper;
use core\entities\sf\Game;
use core\entities\sf\Team;

/**
 * Class ForecastStandings
 * @package core\services\UsersStandings
 *
 * @property Tournament $tournament
 * @property ForecastCalculator $calculatorPrimary
 * @property Team[] $winners
 * @property ForecastStandingsItem[] $forecastStandingsItems
 */

class ForecastStandings
{
    private $calculatorPrimary;
    private $tournament;
    private $winners = null;

    // indicates of the list was sorted already
    private $sort = false;

    public $forecastStandingsItems;

    public function __construct(Tournament $tournament, bool $needDetails, Standings $standings = null)
    {
        foreach ($tournament->users as $user) {
            $this->setStandingItem($user);
        }
        if ($standings) {
            $this->winners = $standings->getWinners();
        }

        $this->tournament = $tournament;
        $this->calculatorPrimary = new ForecastCalculator();
        $this->prepare($needDetails);
    }

    public function prepare(bool $needGameDetails): void
    {
        /** @var Game[] $games */
        $games = $this->tournament->getGames()->withParticipants()->orderBy(['tour' => SORT_ASC, 'date' => SORT_ASC])->all();
        $users = $this->tournament->users;

        if ($this->winners) {
            $forecastedWinnersCalculator = new StandardWinnersForecastCalculator($this->winners);
        }

        foreach ($users as $user) {
            $standingsItem = $this->getStandingsItem($user->id);
            $forecasts = $user->getForecasts()->where(['game_id' => ArrayHelper::getColumn($games, 'id')])->indexBy('game_id')->all();

            $forecastedWinners = $user->getWinnersForecasts()
                    ->andWhere(['tournament_id' => $this->tournament->id])
                    ->with('team')
                    ->orderBy('position')
                    ->indexBy('position')
                    ->all();

            $standingsItem->forecastedWinners = $forecastedWinners;


            if ($this->tournament->isFinished() && $this->winners) {
                $standingsItem->forecastedWinnersResult = $forecastedWinnersCalculator->calculate($forecastedWinners);
                $standingsItem->forecastWinnersPoints += $forecastedWinnersCalculator->totalPoints();
                $standingsItem->points += $standingsItem->forecastWinnersPoints;
            }

            foreach ($games as $game) {
                if ($forecast = ArrayHelper::getValue($forecasts, $game->id)) {
                    $this->calculatorPrimary->assignForecastPoints($forecast, $game->homeScore, $game->guestScore);
                    $standingsItem->setItem($forecast, $game, $needGameDetails);
                } else {
                    $standingsItem->setItem(null,$game, $needGameDetails);
                }
            }
        }
    }

    public function generate(): ?array
    {
        $this->sort();
        $this->sort = true;

        return $this->forecastStandingsItems;
    }

    public function getWinners($number = 3): array
    {
        $this->sort();
        if ($this->tournament->isFinished()) {
            return array_slice($this->forecastStandingsItems, 0, $number, false);
        } else {
            return null;
        }

    }

    public function getWinner(): ?ForecastStandingsItem
    {
        if ($this->tournament->isFinished()) {
            $this->sort();
            return ArrayHelper::getValue(array_slice($this->forecastStandingsItems, 0, 1, false), 0);
        } else {
            return null;
        }
    }

    public function getLeader(): ForecastStandingsItem
    {
        $this->sort();
        return ArrayHelper::getValue(array_slice($this->forecastStandingsItems, 0, 1, false), 0);
    }

    public function getLeaders($number): array
    {
        $this->sort();
        return array_slice($this->forecastStandingsItems, 0, $number, false);
    }

    public function getTourLeaders($tour, $limit)
    {
        $items = $this->forecastStandingsItems;
        $predictors = [];

        foreach ($items as $item) {
            if (!$item->forecastTours[$tour]->isTourForecastEmpty()) {
                $predictor = new TourStandingsItem($item->user->username, $item->forecastTours[$tour]->points);
                $predictors[] = $predictor;
            }
        }

        ArrayHelper::multisort($predictors, 'points', SORT_DESC);

        return array_slice($predictors, 0, $limit, true);
    }


    public function getForecastTourForUser(User $user, $tour): ForecastTour
    {
        return $this->forecastStandingsItems[$user->id]->forecastTours[$tour];
    }

    public function getPosition(User $user): array
    {
        $this->sort();
        $position = 1;
        $foundPos = null;
        $points = null;

        foreach ($this->forecastStandingsItems as $item) {
            if ($item->user->id == $user->id) {
                $foundPos = $position;
                $points = $item->points;
                break;
            } else {
                $position++;
            }
        }

        return ['position' => $foundPos, 'points' => $points];
    }

    private function setStandingItem(User $user): void
    {
        if (!isset($this->forecastStandingsItems[$user->id])) {
            $this->forecastStandingsItems[$user->id] = new ForecastStandingsItem($user);
        }
    }

    private function getStandingsItem($id): ForecastStandingsItem
    {
        return $this->forecastStandingsItems[$id];
    }

    private function sort(): void
    {
        if (!$this->sort)
        {
            ArrayHelper::multisort($this->forecastStandingsItems, ['points', 'exactCount', 'scoreDiffCount'], [SORT_DESC, SORT_DESC, SORT_DESC], [SORT_NUMERIC, SORT_NUMERIC, SORT_NUMERIC]);
            $this->sort = true;
            $this->forecastStandingsItems = ArrayHelper::index($this->forecastStandingsItems, 'user.id');
        }
    }
}