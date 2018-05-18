<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/22/2018
 * Time: 12:48 PM
 */

namespace core\services\sf;


use core\entities\sf\Tournament;
use core\forms\sf\GameForm;
use core\forms\sf\TourGamesForm;
use core\forms\sf\TournamentAliasesForm;
use core\forms\sf\TournamentForm;
use core\repositories\sf\TeamRepository;
use core\repositories\sf\TournamentRepository;
use core\services\parser\Parser;
use yii\helpers\ArrayHelper;

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

    public function assignParticipants($slug, $participants): void
    {
        $tournament = $this->getBySlug($slug);

        if (empty($participants)) {
            throw new \DomainException('Не выбраны команды для добавления');
        }

        $participants = array_map(function ($id) {
            return $this->teams->get($id);
        }, $participants);

        $tournament->assignParticipants(ArrayHelper::getColumn($participants, 'id'));

        $this->tournaments->save($tournament);
    }

    public function removeParticipants($slug, array $remove): void
    {
        $tournament = $this->getBySlug($slug);

        $remove = array_keys(array_filter($remove));
        if (empty($remove)) {
            throw new \DomainException('Не выбраны команды для удаления');
        }

        $participants = array_map(function ($id) {
            return $this->teams->get($id);
        }, $remove);

        $tournament->removeParticipants(ArrayHelper::getColumn($participants, 'id'));

        $this->tournaments->save($tournament);
    }

    public function assignAliases($slug, TournamentAliasesForm $form): void
    {
        $tournament = $this->getBySlug($slug);

        $entities = array_combine(ArrayHelper::getColumn($form->aliases, 'id'), ArrayHelper::getColumn($form->aliases, 'alias'));

        $tournament->assignAliases($entities);
        $this->tournaments->save($tournament);
    }

    public function autoprocess($slug): void
    {
        $tournament = $this->getBySlug($slug);

        if ($tournament->isFinished()) {
            throw new \DomainException('Автопроцессинг не может быть выполнен для законченного турнира');
        }
        if (!$tournament->isAutoprocess()) {
            throw new \DomainException('Автопроцессинг не активирован, либо не указан источник данных');
        }

        $parser = new Parser($tournament);
        $games = $parser->load();
        $tournament->updateGames($games);

        $this->tournaments->save($tournament);
    }

    public function saveTourResults($slug, TourGamesForm $form): void
    {
        $tournament = $this->getBySlug($slug);
        $games = $form->gameForms;
        $tournament->updateTourResult($form->tour, $games);

        $this->tournaments->save($tournament);

    }

    public function remind($slug, $tour): void
    {
        //todo implement reminder
    }

    public function addGame($slug, GameForm $form): void
    {
        $tournament = $this->getBySlug($slug);
        $tournament->addGame($form->tour, $form->homeTeam, $form->guestTeam, $form->date);
        $this->tournaments->save($tournament);
    }

    public function getBySlug($slug): Tournament
    {
        return $this->tournaments->getBySlug($slug);
    }
}