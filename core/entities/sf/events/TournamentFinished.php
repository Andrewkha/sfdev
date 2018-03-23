<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/22/2018
 * Time: 12:21 PM
 */

namespace core\entities\sf\events;


use core\entities\sf\Tournament;

class TournamentFinished
{
    public $tournament;

    public function __construct(Tournament $tournament)
    {
        $this->tournament = $tournament;
    }
}