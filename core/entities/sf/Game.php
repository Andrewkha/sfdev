<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/30/2018
 * Time: 4:58 PM
 */

namespace core\entities\sf;


use yii\db\ActiveRecord;

/**
 * Class Game
 * @package core\entities\sf
 * @property integer $id
 * @property integer $tournament_id
 * @property integer $home_team_id
 * @property integer $guest_team_id
 * @property integer $tour
 * @property integer $homeScore
 * @property integer $guestScore
 * @property integer $date
 */

class Game extends ActiveRecord
{
    private $homePoints;
    private $guestPoints;

    public static function create($tournament, $tour, $home, $guest, $date, $homeScore = null, $guestScore = null): self
    {
        $game = new static();
        $game->tournament_id = $tournament;
        $game->tour = $tour;
        $game->home_team_id = $home;
        $game->guest_team_id = $guest;
        $game->date = $date;
        $game->homeScore = $homeScore;
        $game->guestScore = $guestScore;

        return $game;
    }

    public function assignPoints(int $home, int $guest)
    {
        $this->homePoints = $home;
        $this->guestPoints = $guest;
    }

    public function getHomePoints(): int
    {
        return $this->homePoints;
    }

    public function getGuestPoints(): int
    {
        return $this->guestPoints;
    }

    public function isGameFinished(): bool
    {
        if ($this->homeScore !== NULL && $this->guestScore !== NULL) {
            return true;
        } else {
            return false;
        }
    }

    public function ifHomeWin(): ?bool
    {
        if ($this->isGameFinished() && $this->homeScore > $this->guestScore) {
            return true;
        } else {
            return null;
        }
    }

    public function ifGuestWin(): ?bool
    {
        if ($this->isGameFinished() && $this->homeScore < $this->guestScore) {
            return true;
        } else {
            return null;
        }
    }

    public function ifDraw(): ?bool
    {
        if ($this->isGameFinished() && $this->homeScore == $this->guestScore) {
            return true;
        } else {
            return null;
        }
    }

    public static function tableName()
    {
        return '{{%games}}';
    }
}