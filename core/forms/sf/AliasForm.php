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

    private $tournamentAutoProcess;

    public function __construct(TeamTournaments $teamTournament, bool $autoProcess, array $config = [])
    {
        $this->alias = $teamTournament->alias;
        $this->name = $teamTournament->team->name;
        $this->id = $teamTournament->team_id;

        $this->tournamentAutoProcess = $autoProcess;

        parent::__construct($config);
    }


    public function rules(): array
    {
        return [
            ['alias', 'string', 'max' => 255],
            ['alias', 'required', 'when' => function ($model) {
                    return $this->tournamentAutoProcess == true;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#autoprocess').val() == '1';
                }"
            ]
        ];
    }
 }