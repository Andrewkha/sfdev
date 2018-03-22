<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/22/2018
 * Time: 4:37 PM
 */

namespace core\entities\sf\events;


use core\entities\sf\Tournament;

class TournamentStarted
{
    public $tournament;

    public function __construct(Tournament $tournament)
    {
        $this->tournament = $tournament;
    }
}