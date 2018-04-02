<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 01.04.2018
 * Time: 17:04
 */

namespace backend\widgets\tournament;


use core\entities\sf\Team;
use core\entities\sf\Tournament;
use core\repositories\sf\TeamRepository;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Class ParticipantsManage
 * @package backend\widgets\tournament
 * @property Tournament $tournament
 */

class ParticipantsManage extends Widget
{
    public $tournament;

    private $teams;

    public function __construct(TeamRepository $teams, array $config = [])
    {
        $this->teams = $teams;
        parent::__construct($config);
    }

    public function run(): string
    {
        $participants = ArrayHelper::map($this->tournament->getTeams()->indexBy('id')->orderBy(Team::tableName() . '.name')->all(),
            'id', 'name');
        $allTeamsInCountry = ArrayHelper::map($this->teams->getByCountry($this->tournament->country_id),
            'id', 'name');

        $candidates = array_diff_key($allTeamsInCountry, $participants);


        return $this->render('candidates', [
            'candidates' => $candidates,
            'participants' => $participants,
            'tournament' => $this->tournament,
        ]);
    }
}