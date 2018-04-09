<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/9/2018
 * Time: 2:07 PM
 */

namespace backend\widgets\tournament;


use core\repositories\sf\ForecastRepository;
use core\repositories\sf\TournamentRepository;
use core\services\UsersStandings\ForecastStandings;
use yii\data\ArrayDataProvider;
use yii\base\Widget;

class ForecastStandingsWidget extends Widget
{
    public $tournament;
    private $tournamentRepository;
    private $forecastRepository;

    public function __construct(TournamentRepository $tournamentRepository, ForecastRepository $forecastRepository, array $config = [])
    {
        $this->forecastRepository = $forecastRepository;
        $this->tournamentRepository = $tournamentRepository;
        parent::__construct($config);
    }

    public function run()
    {
        $standings = new ForecastStandings($this->tournament, $this->tournamentRepository, $this->forecastRepository);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $standings->generate(true),
            'sort' => false
        ]);

        return $this->render('forecastStandings', ['dataProvider' => $dataProvider]);
    }
}