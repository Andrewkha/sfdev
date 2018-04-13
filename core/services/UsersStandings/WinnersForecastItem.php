<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/11/2018
 * Time: 5:10 PM
 */

namespace core\services\UsersStandings;


class WinnersForecastItem
{
    public $event;
    public $points;

    public function __construct($event, $points)
    {
        $this->points = $points;
        $this->event = $event;
    }
}