<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 5/17/2018
 * Time: 3:11 PM
 */

namespace core\listeners;

use core\entities\sf\events\TournamentTourFinished;
use core\repositories\sf\TournamentRepository;
use core\services\notifier\Notifier;
use core\services\notifier\TourFinishedNotification;
use core\services\UsersStandings\ForecastStandings;
use yii\mail\MailerInterface;
use yii\log\Logger;

class TournamentTourFinishedListener
{
    private $repository;

    public $mailer;
    public $logger;

    public function __construct(TournamentRepository $repository, MailerInterface $mailer, Logger $logger)
    {
        $this->repository = $repository;
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function handle(TournamentTourFinished $event)
    {
        $tournament= $event->tournament;
        $tour = $event->tour;
        // if this is the last tour, do not send tour results, send the tournament finished notification instead

        if ($tournament->tours == $tour) {
            return;
        }

        if (!$tournament->isTourNotificationEligible($tour)) {
            return;
        }

        $standings = new ForecastStandings($tournament, true);

        $forecasters = $tournament->users;
        foreach ($forecasters as $forecaster) {
            $notifier = new Notifier(
                new TourFinishedNotification($tournament, $forecaster, $tour, $standings),
                $this->mailer,
                $this->logger
            );
            $notifier->sendEmails();
        }

        $tournament->addTourNotification($tour, time());

        $this->repository->save($tournament);
    }
}