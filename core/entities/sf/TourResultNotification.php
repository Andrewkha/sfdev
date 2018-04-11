<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/11/2018
 * Time: 12:38 PM
 */

namespace core\entities\sf;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class TourResultNotification
 * @package core\entities\sf
 *
 * @property integer $tournament_id
 * @property integer $tour
 * @property integer $date
 *
 * @property Tournament $tournament
 */

class TourResultNotification extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tour_result_notifications}}';
    }

    public function getTournament(): ActiveQuery
    {
        return $this->hasOne(Tournament::class, ['id' => 'tournament_id']);
    }
}