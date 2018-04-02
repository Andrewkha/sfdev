<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/2/2018
 * Time: 12:56 PM
 */

namespace core\forms\sf;

use core\entities\sf\Tournament;
use core\forms\CompositeForm;


/**
 * Class AliasesForm
 * @package core\forms\sf
 * @property AliasForm[] $aliasForms
 */

class TournamentAliasesForm extends CompositeForm
{
    public $aliasForms;

    public function __construct(Tournament $tournament, array $config = [])
    {
        $participants = $tournament->teamAssignments;
        foreach ($participants as $one) {
            $this->aliasForms[] = new AliasForm($one);
        }
        parent::__construct($config);
    }

    public function internalForms(): array
    {
        return ['alias'];
    }
}