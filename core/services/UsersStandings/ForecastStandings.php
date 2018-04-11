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
use core\repositories\sf\ForecastRepository;
use core\repositories\sf\TournamentRepository;
use core\services\UsersStandings\calculator\ForecastCalculator;
use core\services\UsersStandings\calculator\ForecastCalculatorInterface;
use yii\helpers\ArrayHelper;
use core\entities\sf\Game;

/**
 * Class ForecastStandings
 * @package core\services\UsersStandings
 *
 * @property Tournament $tournament
 * @property TournamentRepository $tournamentRepository
 * @property ForecastRepository $forecastRepository
 * @property ForecastCalculatorInterface $calculator
 * @property ForecastStandingsItem[] $forecastStandingsItems
 */

class ForecastStandings
{
    private $calculatorPrimary;
    private $tournament;
    public $forecastStandingsItems;

    public function __construct(Tournament $tournament, bool $needDetails)
    {
        foreach ($tournament->users as $user) {
            $this->setStandingItem($user);
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

        foreach ($users as $user) {
            $standingsItem = $this->getStandingsItem($user->id);
            $forecasts = $user->getForecasts()->where(['game_id' => ArrayHelper::getColumn($games, 'id')])->indexBy('game_id')->all();

            foreach ($games as $game) {
                if ($forecast = ArrayHelper::getValue($forecasts, $game->id)) {
                    $this->calculatorPrimary->assignForecastPoints($forecast, $game->homeScore, $game->guestScore);
                    $standingsItem->setItem($forecast, $game, $needGameDetails);
                } else {
                    $standingsItem->setItem(null,$game, $needGameDetails);
                }
            }
        }

        ArrayHelper::multisort($this->forecastStandingsItems, ['points', 'exactCount', 'scoreDiffCount'], [SORT_DESC, SORT_DESC, SORT_DESC], [SORT_NUMERIC, SORT_NUMERIC, SORT_NUMERIC]);
    }

    public function generate(): array
    {
        return $this->forecastStandingsItems;
    }

    public function getWinners()
    {
        return ArrayHelper::getColumn(array_slice($this->forecastStandingsItems, 0, 3, true), 'user');
    }

    public function getWinner()
    {
        return ArrayHelper::getColumn(array_slice($this->forecastStandingsItems, 0, 1, true), 'user');
    }

    public function getPosition(User $user)
    {

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
}