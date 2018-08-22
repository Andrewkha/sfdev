<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 8/20/2018
 * Time: 5:08 PM
 */

namespace core\services\UsersStandings;


class TourStandingsItem
{
    public $username;
    public $points;


    public function __construct($username, $points)
    {
        $this->username = $username;
        $this->points = $points;
    }
}