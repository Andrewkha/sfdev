<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/13/2018
 * Time: 3:23 PM
 */

namespace core\services\UsersStandings;


class WinnersForecastResultItem
{
    public $event;
    public $points;
    public $team;
    public $text;

    public function __construct($event, $team = null)
    {
        $this->event = $event;
        $this->team = $team;
    }
}