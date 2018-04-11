<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/9/2018
 * Time: 2:07 PM
 */

namespace backend\widgets\tournament;

use core\services\UsersStandings\ForecastStandings;
use yii\data\ArrayDataProvider;
use yii\base\Widget;

class ForecastStandingsWidget extends Widget
{
    public $tournament;

    public function run()
    {
        $standings = new ForecastStandings($this->tournament, true);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $standings->generate(),
            'sort' => false
        ]);

        return $this->render('forecastStandings', ['dataProvider' => $dataProvider]);
    }
}