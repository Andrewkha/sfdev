<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/22/2018
 * Time: 12:48 PM
 */

namespace core\services\sf;


use core\entities\sf\Tournament;
use core\forms\sf\TournamentAliasesForm;
use core\forms\sf\TournamentForm;
use core\repositories\sf\TeamRepository;
use core\repositories\sf\TournamentRepository;

class TournamentManageService
{
    private $tournaments;
    private $teams;

    public function __construct(TournamentRepository $tournamentRepository, TeamRepository $teamRepository)
    {
        $this->tournaments = $tournamentRepository;
        $this->teams = $teamRepository;
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

    public function edit($slug, TournamentForm $form): Tournament
    {
        $tournament = $this->getBySlug($slug);
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

        return $tournament;
    }

    public function start($slug): void
    {
        $tournament = $this->getBySlug($slug);
        $tournament->start();
        $this->tournaments->save($tournament);
    }

    public function finish($slug): void
    {
        $tournament = $this->getBySlug($slug);
        $tournament->finish();
        $this->tournaments->save($tournament);
    }

    public function remove($slug): void
    {
        $tournament = $this->getBySlug($slug);
        $this->tournaments->remove($tournament);
    }

    public function assignParticipants($slug, array $participants): void
    {
        $tournament = $this->getBySlug($slug);

        foreach ($participants as $id) {
            $participant = $this->teams->get($id);
            $tournament->assignParticipant($participant->id);
        }

        $this->tournaments->save($tournament);
    }

    public function removeParticipants($slug, array $remove): void
    {
        $tournament = $this->getBySlug($slug);

        $remove = array_keys(array_filter($remove));

        foreach ($remove as $id) {
            $participant = $this->teams->get($id);
            $tournament->removeParticipant($participant->id);
        }

        $this->tournaments->save($tournament);
    }

    public function assignAliases($slug, TournamentAliasesForm $form): void
    {
        $tournament = $this->getBySlug($slug);
        print_r($form); exit;
    }

    public function getBySlug($slug): Tournament
    {
        return $this->tournaments->getBySlug($slug);
    }
}