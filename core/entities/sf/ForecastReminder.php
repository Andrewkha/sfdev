<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/11/2018
 * Time: 12:33 PM
 */

namespace core\entities\sf;

use core\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ForecastReminders
 * @package core\repositories\sf
 *
 * @property integer $user_id
 * @property integer $tournament_id
 * @property integer $tour
 * @property integer $date
 *
 * @property User $user
 * @property Tournament $tournament
 */

class ForecastReminder extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%forecast_reminders}}';
    }

    public static function create($userId, $tour, $date): self
    {
        $reminder = new self();
        $reminder->user_id = $userId;
        $reminder->tour = $tour;
        $reminder->date = $date;

        return $reminder;
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTournament(): ActiveQuery
    {
        return $this->hasOne(Tournament::class, ['id' => 'tournament_id']);
    }
}