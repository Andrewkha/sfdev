<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/22/2018
 * Time: 12:48 PM
 */

namespace core\services\sf;


use core\repositories\sf\TournamentRepository;

class TournamentManageService
{
    public $tournaments;

    public function __construct(TournamentRepository $tournamentRepository)
    {
        $this->tournaments = $tournamentRepository;
    }
}