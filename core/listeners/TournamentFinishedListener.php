<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/22/2018
 * Time: 12:24 PM
 */

namespace core\listeners;


use core\entities\sf\events\TournamentFinished;
use yii\log\Logger;
use yii\mail\MailerInterface;

class TournamentFinishedListener
{
    public $mailer;
    public $logger;

    public function __construct(MailerInterface $mailer, Logger $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function handle(TournamentFinished $event)
    {
        print_r($event->tournament->name . 'finished'); exit;
    }
}