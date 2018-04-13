<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/11/2018
 * Time: 12:41 PM
 */

namespace core\entities\sf;

use core\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class WinnersForecast
 * @package core\entities\sf
 *
 * @property integer $user_id
 * @property integer $tournament_id
 * @property integer $team_id
 * @property integer $position
 * @property integer $date
 *
 * @property User $user
 * @property Tournament $tournament
 * @property Team $team
 */

class WinnersForecast extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%winners_forecast}}';
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTournament(): ActiveQuery
    {
        return $this->hasOne(Tournament::class, ['id' => 'tournament_id']);
    }

    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['id' => 'team_id']);
    }
}