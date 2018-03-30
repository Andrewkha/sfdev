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

    public static function tableName()
    {
        return '{{%games}}';
    }
}