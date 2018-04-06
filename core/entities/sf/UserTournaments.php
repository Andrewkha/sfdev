<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/6/2018
 * Time: 3:29 PM
 */

namespace core\entities\sf;

use core\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class UserTournaments
 * @package core\entities\sf
 *
 * @property  integer $user_id
 * @property  integer $tournament_id
 * @property  boolean $notification
 */

class UserTournaments extends ActiveRecord
{

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTournament(): ActiveQuery
    {
        return $this->hasOne(Tournament::class, ['id' => 'tournament_id']);
    }

    public static function tableName()
    {
        return '{{%users_tournaments}}';
    }
}