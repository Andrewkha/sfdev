<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/5/2018
 * Time: 5:55 PM
 */

namespace backend\widgets\tournament;


use core\entities\sf\Tournament;
use core\repositories\sf\TournamentRepository;
use yii\base\Widget;
use core\services\TeamStandings\Standings;
use yii\data\ArrayDataProvider;

/**
 * Class Standings
 * @package backend\widgets\tournament
 *
 * @property Tournament $tournament;
 * @property Standings $standings
 */

class StandingsWidget extends Widget
{
    public $tournament;
    private $repository;

    public function __construct(TournamentRepository $repository, array $config = [])
    {
        $this->repository = $repository;
        parent::__construct($config);
    }

    public function run()
    {
        $standings = new Standings($this->tournament, $this->repository, true);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $standings->generate(),
            'sort' => false
        ]);

        return $this->render('standings', ['dataProvider' => $dataProvider]);
    }
}