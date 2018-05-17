<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 5/17/2018
 * Time: 3:09 PM
 */

namespace core\entities\sf\events;

use core\entities\sf\Tournament;

class TournamentTourFinished
{
    public $tournament;
    public $tour;

    public function __construct(Tournament $tournament, $tour)
    {
        $this->tournament = $tournament;
        $this->tour = $tour;
    }
}