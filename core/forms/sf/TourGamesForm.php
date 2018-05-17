<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/16/2018
 * Time: 5:10 PM
 */

namespace core\forms\sf;

use core\entities\sf\Game;
use core\entities\sf\Tournament;
use elisdn\compositeForm\CompositeForm;

/**
 * Class TourGamesForm
 * @package core\forms\sf
 *
 * @property GameForm[] $gameForms
 */

class TourGamesForm extends CompositeForm
{

    public $tour;

    public function __construct(Tournament $tournament, $tour, array $config = [])
    {
        $this->tour = $tour;

        $gameForms = [];
        /** @var Game[] $games */
        $games = $tournament->getGames()->where(['tour' => $tour])->orderBy(['date' => SORT_ASC])->withParticipants()->all();

        foreach ($games as $game) {
            $gameForms[$game->id] = new GameForm($tournament->tours, $game);
        }

        $this->gameForms = $gameForms;
        parent::__construct($config);
    }

    public function internalForms(): array
    {
        return ['gameForms'];
    }
}