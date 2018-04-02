<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/2/2018
 * Time: 12:56 PM
 */

namespace core\forms\sf;

use core\entities\sf\Tournament;
use elisdn\compositeForm\CompositeForm;
use yii\helpers\ArrayHelper;


/**
 * Class TournamentAliasesForm
 * @package core\forms\sf
 * @property AliasForm[] $aliases
 * @property Tournament $tournament
 */

class TournamentAliasesForm extends CompositeForm
{
    private $tournament;

    public function __construct(Tournament $tournament, array $config = [])
    {
        $participants = $tournament->teamAssignments;
        $aliases = [];
        foreach ($participants as $one) {
            $aliases[$one->team_id] = new AliasForm($one, $tournament->autoprocess);
        }

        $this->aliases = $aliases;
        $this->tournament = $tournament;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['aliases', function ($attribute, $params, $validator) {
                if ($this->tournament->autoprocess) {
                    $values = ArrayHelper::getColumn($this->aliases, 'alias');
                    $uniqueValues = array_unique($values);
                    if ($values != $uniqueValues) {
                        $this->addError($attribute, 'Значения должны быть уникальны');
                    }
                }
            }]
        ];
    }

    public function internalForms(): array
    {

        return ['aliases'];
    }
}