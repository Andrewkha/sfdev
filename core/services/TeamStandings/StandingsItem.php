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
 * @property GameItem[] $gameItems
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

    public $gameItems;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function setItems(Game $game, bool $home): void
    {
        if ($game->isGameFinished()) {
            $homeScore = $game->homeScore;
            $guestScore = $game->guestScore;
            $this->gamesPlayed++;
            if ($home) {
                $this->goalsScored += $homeScore;
                $this->goalsMissed += $guestScore;
                $this->points += $game->getHomePoints();
                if ($game->ifHomeWin()) {
                    $this->gamesWon++;
                    $outcome = GameItem::RESULT_WIN;
                } elseif ($game->ifGuestWin()) {
                    $this->gamesLost++;
                    $outcome = GameItem::RESULT_LOST;
                }
                $homeTeam = $this->team->name;
                $guestTeam = $game->guestTeam->name;

            } else {
                $this->goalsScored += $guestScore;
                $this->goalsMissed += $homeScore;
                $this->points += $game->getGuestPoints();
                if ($game->ifHomeWin()) {
                    $this->gamesLost++;
                    $outcome = GameItem::RESULT_LOST;
                } elseif ($game->ifGuestWin()) {
                    $this->gamesWon++;
                    $outcome = GameItem::RESULT_WIN;
                }
                $homeTeam = $game->homeTeam->name;
                $guestTeam = $this->team->name;
            }

            if ($game->ifDraw()) {
                $this->gamesDraw++;
                $outcome = GameItem::RESULT_DRAW;
            }

            $this->gameItems[$game->tour] = new GameItem($game->tour, $game->date, $outcome, $homeTeam, $guestTeam, $homeScore, $guestScore);
        }

    }
}