<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/6/2018
 * Time: 5:40 PM
 */

namespace core\repositories\sf;


use core\entities\sf\Forecast;

class ForecastRepository
{
    public function forUserAndGames($user_id, array $games)
    {
        return Forecast::find()->forUser($user_id)->forGames(null, $games)->indexBy('game_id')->all();
    }
}