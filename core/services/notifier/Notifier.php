<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 5/23/2018
 * Time: 4:16 PM
 */

namespace core\services\notifier;

use yii\log\Logger;
use yii\mail\MailerInterface;

class Notifier
{
    private $notification;
    private $mailer;
    private $logger;


    public function __construct(NotificationInterface $notification, MailerInterface $mailer, Logger $logger)
    {
        $this->notification = $notification;
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function sendEmails()
    {
        $recipient = $this->notification->getToUser();
        $template = $this->notification->getTemplate();
        $subject = $this->notification->getSubject();
        $loggerCategory = $this->notification->getLoggerCategory();

        if (!$this->notification->isAllowSendNotification()) {
            return;
        }

        $data = $this->notification->getContent();

        $send = $this->mailer->compose($template, $data)
            ->setTo($recipient->email)
            ->setSubject($subject)
            ->send();

        if (!$send) {
            $message = $this->notification->getErrorMessage();
            $this->logger->log($message, LOGGER::LEVEL_ERROR, $loggerCategory);
        } else {
            $this->notification->afterAction();
            $message = $this->notification->getSuccessMessage();
            $this->logger->log($message, LOGGER::LEVEL_INFO, $loggerCategory);
        }
    }
}