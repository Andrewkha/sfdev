<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/22/2018
 * Time: 4:39 PM
 */

namespace core\listeners;


use core\entities\sf\events\TournamentStarted;
use yii\log\Logger;
use yii\mail\MailerInterface;

class TournamentStartedListener
{
    public $mailer;
    public $logger;

    public function __construct(MailerInterface $mailer, Logger $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function handle(TournamentStarted $event)
    {

    }
}