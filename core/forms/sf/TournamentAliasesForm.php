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
 * @property bool $autoprocess
 */

class TournamentAliasesForm extends CompositeForm
{
    private $autoprocess;

    public function __construct(Tournament $tournament, array $config = [])
    {
        $participants = $tournament->teamAssignments;
        $this->autoprocess = $tournament->isAutoprocess();
        $aliases = [];
        foreach ($participants as $one) {
            $aliases[$one->team_id] = new AliasForm($one, $this->autoprocess);
        }

        $this->aliases = $aliases;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['aliases', function ($attribute, $params, $validator) {
                if ($this->autoprocess) {
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