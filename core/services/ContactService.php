<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/13/2018
 * Time: 1:00 PM
 */

namespace core\services;


use core\forms\ContactForm;
use yii\mail\MailerInterface;

class ContactService
{
    public $mailer;
    public $to;
    public $appName;

    public function __construct(MailerInterface $mailer, $to, $appName)
    {
        $this->mailer = $mailer;
        $this->to = $to;
        $this->appName = $appName;
    }

    public function send(ContactForm $form)
    {
        $sent = $this->mailer->compose()
            ->setTo($this->to)
            ->setFrom([$form->email => $form->username])
            ->setReplyTo($form->email)
            ->setSubject('Сообщение от пользователя ' . $this->appName . ': ' . $form->subject)
            ->setHtmlBody($form->body)
            ->send();

        if (!$sent)
            throw new \RuntimeException('Ошибка отправки сообщения');
    }
}