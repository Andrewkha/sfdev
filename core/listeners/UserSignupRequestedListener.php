<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/22/2018
 * Time: 3:54 PM
 */

namespace core\listeners;


use core\entities\user\events\UserSignupRequested;
use yii\log\Logger;
use yii\mail\MailerInterface;

class UserSignupRequestedListener
{
    private $mailer;
    private $logger;

    public function __construct(MailerInterface $mailer, Logger $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function handle(UserSignupRequested $event): void
    {
        $sent = $this->mailer
            ->compose(
                ['html' => 'auth/signup/request-html', 'text' => 'auth/signup/request-txt'],
                ['user' => $event->user]
            )
            ->setTo($event->user->email)
            ->setSubject(\Yii::$app->name . ': Подтверждение реистрации');

        if (!$sent) {
            $message = 'Signup confirmation email sending error for ' . $event->user->username;
            $this->logger->log($message, LOGGER::LEVEL_ERROR);
            throw new \RuntimeException($message);
        }
    }
}