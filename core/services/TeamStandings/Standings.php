<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/5/2018
 * Time: 2:26 PM
 */

namespace core\services\TeamStandings;

use core\entities\sf\Game;
use core\entities\sf\Team;
use core\entities\sf\Tournament;
use core\repositories\sf\TournamentRepository;
use core\services\TeamStandings\calculator\GameCalculator;
use yii\helpers\ArrayHelper;

/**
 * Class Standings
 * @package core\services\TeamStandings
 *
 * @property Game[] $games
 * @property StandingsItem[] $standingsItems
 * @property GameCalculator $calculator
 */

class Standings
{
    private $games;
    private $standingsItems;
    private $calculator;

    public function __construct(Tournament $tournament, TournamentRepository $repository, bool $needDetails)
    {
        $this->games = $repository->getFinishedGames($tournament);
        foreach ($tournament->teams as $team) {
            $this->setStandingItem($team);
        }
        $this->calculator = new GameCalculator($tournament);
        $this->prepare($needDetails);
    }

    private function prepare(bool $needDetails): void
    {
        foreach ($this->games as $game) {
            $this->calculator->assignGamePoints($game);
            $home = $this->getStandingsItem($game->home_team_id);
            $guest = $this->getStandingsItem($game->guest_team_id);
            $home->setItems($game, true, $needDetails);
            $guest->setItems($game, false, $needDetails);
        }

        ArrayHelper::multisort($this->standingsItems, ['points', 'gamesWon', 'gamesLost'], [SORT_DESC, SORT_DESC, SORT_ASC], [SORT_NUMERIC, SORT_NUMERIC, SORT_NUMERIC]);
    }

    public function generate(): array
    {
        return $this->standingsItems;
    }

    public function getWinners()
    {
        return ArrayHelper::getColumn(array_slice($this->standingsItems, 0, 3, true), 'team');
    }

    private function setStandingItem(Team $team)
    {
        if (!isset($this->standingsItems[$team->id])) {
            $this->standingsItems[$team->id] = new StandingsItem($team);
        }
    }

    private function getStandingsItem($id): StandingsItem
    {
        return $this->standingsItems[$id];
    }


}