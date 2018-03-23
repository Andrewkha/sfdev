<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/22/2018
 * Time: 12:48 PM
 */

namespace core\services\sf;


use core\entities\sf\Tournament;
use core\forms\sf\TournamentForm;
use core\repositories\sf\TournamentRepository;

class TournamentManageService
{
    public $tournaments;

    public function __construct(TournamentRepository $tournamentRepository)
    {
        $this->tournaments = $tournamentRepository;
    }

    public function create(TournamentForm $form): Tournament
    {
        $tournament = Tournament::create(
            $form->name,
            $form->slug,
            $form->type,
            $form->country_id,
            $form->tours,
            $form->startDate,
            $form->autoprocess,
            $form->autoprocessUrl,
            $form->winnersForecastDue
        );

        $this->tournaments->save($tournament);

        return $tournament;
    }

    public function edit($slug, TournamentForm $form): void
    {
        $tournament = $this->tournaments->getBySlug($slug);
        $tournament->edit(
            $form->name,
            $form->slug,
            $form->type,
            $form->country_id,
            $form->tours,
            $form->startDate,
            $form->autoprocess,
            $form->autoprocessUrl,
            $form->winnersForecastDue
        );

        $this->tournaments->save($tournament);
    }
}