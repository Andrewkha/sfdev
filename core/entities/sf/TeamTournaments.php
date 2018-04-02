<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/30/2018
 * Time: 3:59 PM
 */

namespace core\entities\sf;


use yii\db\ActiveRecord;

/**
 * Class TeamTournaments
 * @package core\entities\sf
 * @property integer $team_id
 * @property integer $tournament_id
 * @property string $alias
 */
class TeamTournaments extends ActiveRecord
{
    public static function create($team_id): self
    {
        $assignment = new static();
        $assignment->team_id = $team_id;

        return $assignment;
    }

    public function isForTeam($id): bool
    {
        return $this->team_id == $id;
    }

    public static function tableName()
    {
       return '{{%team_tournament}}';
    }
}