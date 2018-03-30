<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/30/2018
 * Time: 5:01 PM
 */

namespace core\entities\sf;


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
 */

class Forecast extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%forecasts}}';
    }
}