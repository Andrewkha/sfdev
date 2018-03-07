<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/7/2018
 * Time: 2:51 PM
 */

namespace core\listeners;


use core\entities\user\events\PasswordResetRequestSubmitted;

use yii\log\Logger;
use yii\mail\MailerInterface;

class UserPasswordResetRequestSubmittedListener
{
    public $mailer;
    public $logger;

    public function __construct(MailerInterface $mailer, Logger $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function handle(PasswordResetRequestSubmitted $event): void
    {
        $sent = $this->mailer
            ->compose(
                ['html' => 'auth/reset/request-html', 'text' => 'auth/reset/request-txt'],
                ['user' => $event->user]
            )
            ->setTo($event->user->email)
            ->setSubject(\Yii::$app->name . ': Восстановление пароля')
            ->send();

        if (!$sent) {
            $message = 'Password reset email sending error for ' . $event->user->username;
            $this->logger->log($message, LOGGER::LEVEL_ERROR);
            throw new \RuntimeException($message);
        }
    }
}