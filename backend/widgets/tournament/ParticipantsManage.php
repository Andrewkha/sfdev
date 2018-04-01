<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 01.04.2018
 * Time: 17:04
 */

namespace backend\widgets\tournament;


use core\entities\sf\Tournament;
use core\repositories\sf\TeamRepository;
use yii\base\Widget;

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
        $participants = $this->tournament->getTeams()->indexBy('id')->all();
        $allTeamInCountry = $this->teams->getByCountry($this->tournament->country_id);

        $candidates = array_intersect_key($allTeamInCountry, $participants);

        return $this->render('candidates', ['candidates' => $candidates]);
    }
}