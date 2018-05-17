<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/30/2018
 * Time: 4:58 PM
 */

namespace core\entities\sf;


use core\entities\sf\queries\GameQuery;
use yii\db\ActiveQuery;
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
 *
 * @property Team $homeTeam;
 * @property Team $guestTeam;
 * @property Forecast[] $forecasts
 */

class Game extends ActiveRecord
{
    private $homePoints;
    private $guestPoints;

    public static function create($tour, $home, $guest, $date, $homeScore = null, $guestScore = null): self
    {
        $game = new static();
        $game->tour = $tour;
        $game->home_team_id = $home;
        $game->guest_team_id = $guest;
        $game->date = $date;
        $game->homeScore = $homeScore;
        $game->guestScore = $guestScore;

        return $game;
    }

    public function edit($tour, $home, $guest, $date, $homeScore, $guestScore): void
    {
        $this->tour = $tour;
        $this->home_team_id = $home;
        $this->guest_team_id = $guest;
        $this->date = $date;
        $this->homeScore = $homeScore;
        $this->guestScore = $guestScore;
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

    public function isFinished(): bool
    {
        if ($this->homeScore !== NULL && $this->guestScore !== NULL) {
            return true;
        } else {
            return false;
        }
    }

    public function ifHomeWin(): ?bool
    {
        if ($this->isFinished() && $this->homeScore > $this->guestScore) {
            return true;
        } else {
            return null;
        }
    }

    public function ifGuestWin(): ?bool
    {
        if ($this->isFinished() && $this->homeScore < $this->guestScore) {
            return true;
        } else {
            return null;
        }
    }

    public function ifDraw(): ?bool
    {
        if ($this->isFinished() && $this->homeScore == $this->guestScore) {
            return true;
        } else {
            return null;
        }
    }

    public function getHomeTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['id' => 'home_team_id']);
    }

    public function getGuestTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['id' => 'guest_team_id']);
    }

    public function getForecasts(): ActiveQuery
    {
        return $this->hasMany(Forecast::class, ['game_id' => 'id']);
    }

    public static function tableName()
    {
        return '{{%games}}';
    }

    /**
     * @return GameQuery
     */

    public static function find(): GameQuery
    {
        return new GameQuery(static::class);
    }
}