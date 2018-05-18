<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/22/2018
 * Time: 12:24 PM
 */

namespace core\listeners;


use core\entities\sf\events\TournamentFinished;
use core\repositories\sf\TournamentRepository;
use yii\log\Logger;
use yii\mail\MailerInterface;

class TournamentFinishedListener
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

    public function handle(TournamentFinished $event)
    {
        print_r($event->tournament->name . 'finished');
        $event->tournament->addTourNotification($event->tournament->tours, time());
        $this->repository->save($event->tournament);
    }
}