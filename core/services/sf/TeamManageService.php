<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/15/2018
 * Time: 11:01 AM
 */

namespace core\services\sf;


use core\repositories\sf\TeamRepository;

class TeamManageService
{
    public $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

}