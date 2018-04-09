<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/30/2018
 * Time: 5:01 PM
 */

namespace core\entities\sf;


use core\entities\sf\queries\ForecastQuery;
use core\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Forecast
 * @package core\entities\sf
 * @property integer $id
 * @property integer $game_id
 * @property integer $user_id
 * @property integer $homeFscore
 * @property integer $guestFscore
 * @property integer $date
 *
 * @property Game $game
 * @property User $user
 */

class Forecast extends ActiveRecord
{

    const OUTCOME_FULL_MATCH = 'match';
    const OUTCOME_SCORE_DIFF = 'score_diff';
    const OUTCOME_WINNER = 'winner';
    const OUTCOME_NONE = 'none';


    private $points;

    public function assignPoints(int $points)
    {
        $this->points = $points;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function getGame(): ActiveQuery
    {
        return $this->hasOne(Game::class, ['id' => 'game_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function tableName()
    {
        return '{{%forecasts}}';
    }

    private function forecastOutcome(int $homeScore, int $guestScore): string
    {
        if ($homeScore === NULL || $guestScore === NULL) {
            return '';
        }

        if ($homeScore === $this->homeFscore && $guestScore === $this->guestFscore) {
            return self::OUTCOME_FULL_MATCH;
        }

        if (($homeScore - $guestScore) === ($this->homeFscore - $this->guestFscore)) {
            return self::OUTCOME_SCORE_DIFF;
        }

        if ((($homeScore - $guestScore) > 0 && ($this->homeFscore - $this->guestFscore) > 0)
            || (($homeScore - $guestScore) < 0 && ($this->homeFscore - $this->guestFscore) < 0)) {

            return self::OUTCOME_WINNER;
        }
        return self::OUTCOME_NONE;
    }

    public function isFullMatch(int $homeScore, int $guestScore): bool
    {
        return $this->forecastOutcome($homeScore, $guestScore) === self::OUTCOME_FULL_MATCH;
    }

    public function isScoreDiff(int $homeScore, int $guestScore): bool
    {
        return $this->forecastOutcome($homeScore, $guestScore) === self::OUTCOME_SCORE_DIFF;
    }

    public function isWinner(int $homeScore, int $guestScore): bool
    {
        return $this->forecastOutcome($homeScore, $guestScore) === self::OUTCOME_WINNER;
    }

    public function isNone(int $homeScore, int $guestScore): bool
    {
        return $this->forecastOutcome($homeScore, $guestScore) === self::OUTCOME_NONE;
    }

    /**
     * @return ForecastQuery
     */

    public static function find(): ForecastQuery
    {
        return new ForecastQuery(static::class);
    }
}