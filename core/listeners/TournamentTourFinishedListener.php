<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 5/17/2018
 * Time: 3:11 PM
 */

namespace core\listeners;

use core\entities\sf\events\TournamentTourFinished;
use yii\mail\MailerInterface;
use yii\log\Logger;

class TournamentTourFinishedListener
{
    public $mailer;
    public $logger;

    public function __construct(MailerInterface $mailer, Logger $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function handle(TournamentTourFinished $event)
    {
        // if this is the last tour, do not send tour results, send the tournament finished notification instead
        if ($event->tournament->tours == $event->tour) {

            return;
        }

        print_r('Тур ' . $event->tour . ' закончен'); exit;
    }
}