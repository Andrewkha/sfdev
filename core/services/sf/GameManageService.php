<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 5/7/2018
 * Time: 4:13 PM
 */

namespace core\services\sf;


use core\entities\sf\Game;
use core\repositories\sf\GameRepository;

class GameManageService
{
    private $games;

    public function __construct(GameRepository $games)
    {
        $this->games = $games;
    }

    public function get($id): Game
    {
        return $this->games->get($id);
    }

    public function remove($id): void
    {
        $game = $this->get($id);
        $this->games->remove($game);
    }
}