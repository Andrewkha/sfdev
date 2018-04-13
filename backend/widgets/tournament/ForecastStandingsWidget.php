<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/9/2018
 * Time: 2:07 PM
 */

namespace backend\widgets\tournament;

use core\entities\sf\Tournament;
use core\services\TeamStandings\Standings;
use core\services\UsersStandings\ForecastStandings;
use yii\data\ArrayDataProvider;
use yii\base\Widget;

/**
 * Class ForecastStandingsWidget
 * @package backend\widgets\tournament
 *
 * @property Tournament $tournament
 */

class ForecastStandingsWidget extends Widget
{
    public $tournament;

    public function run()
    {
        $standings = new Standings($this->tournament, false);
        $winners = $standings->getWinners();

        $forecastStandings = new ForecastStandings($this->tournament, true, $winners);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $forecastStandings->generate(),
            'sort' => false
        ]);

        return $this->render('forecastStandings', ['dataProvider' => $dataProvider]);
    }
}