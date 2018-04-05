<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/5/2018
 * Time: 2:17 PM
 */

namespace core\services\TeamStandings;


use core\entities\sf\Game;
use core\entities\sf\Team;

/**
 * Class StandingsItem
 * @package core\services\TeamStandings
 *
 * @property Team $team
 * @property integer $gamesPlayed
 * @property integer $goalsScored
 * @property integer $goalsMissed
 * @property integer $points
 * @property integer $gamesWon
 * @property integer $gamesLost
 * @property integer $gamesDraw
 *
 */

class StandingsItem
{
    public $team;
    public $gamesPlayed = 0;
    public $goalsScored = 0;
    public $goalsMissed = 0;
    public $points = 0;
    public $gamesWon = 0;
    public $gamesLost = 0;
    public $gamesDraw = 0;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function setItems(Game $game, bool $home): void
    {
        if ($game->isGameFinished()) {
            $this->gamesPlayed++;
            if ($home) {
                $this->goalsScored += $game->homeScore;
                $this->goalsMissed += $game->guestScore;
                $this->points += $game->getHomePoints();
                if ($game->ifHomeWin()) {
                    $this->gamesWon++;
                } elseif ($game->ifGuestWin()) {
                    $this->gamesLost++;
                }

            } else {
                $this->goalsScored += $game->guestScore;
                $this->goalsMissed += $game->homeScore;
                $this->points += $game->getGuestPoints();
                if ($game->ifHomeWin()) {
                    $this->gamesLost++;
                } elseif ($game->ifGuestWin()) {
                    $this->gamesWon++;
                }
            }
            if ($game->ifDraw()) {
                $this->gamesDraw++;
            }
        }

    }
}