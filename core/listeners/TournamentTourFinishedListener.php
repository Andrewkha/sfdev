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
use yii\mail\MailerInterface;
use yii\log\Logger;

class TournamentTourFinishedListener
{
    public $mailer;
    public $logger;

    private $repository;

    public function __construct(MailerInterface $mailer, Logger $logger, TournamentRepository $repository)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->repository = $repository;
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

        print_r('Тур ' . $tour . ' закончен');
        $tournament->addTourNotification($tour, time());
        $this->repository->save($tournament);
    }
}