<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/2/2018
 * Time: 2:14 PM
 */

namespace core\forms\sf;


use core\entities\sf\TeamTournaments;
use yii\base\Model;

class AliasForm extends Model
{
    public $alias;
    public $name;
    public $id;

    public function __construct(TeamTournaments $teamTournament, array $config = [])
    {
        $this->alias = $teamTournament->alias;
        $this->name = $teamTournament->team->name;
        $this->id = $teamTournament->team_id;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['alias', 'string', 'max' => 255]
        ];
    }
}