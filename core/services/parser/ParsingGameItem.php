<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/16/2018
 * Time: 1:48 PM
 */

namespace core\services\parser;


class ParsingGameItem
{
    public $tour;
    public $home;
    public $guest;
    public $homeScore = null;
    public $guestScore = null;
    public $date;

    public function __construct($date, $tour, $home, $guest, $homeScore, $guestScore)
    {
        $this->date = $date;
        $this->tour = $tour;
        $this->home = $home;
        $this->guest = $guest;
        $this->homeScore = $homeScore;
        $this->guestScore = $guestScore;
    }
}