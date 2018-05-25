<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 5/18/2018
 * Time: 3:08 PM
 */

namespace core\services\notifier;


use core\entities\user\User;

interface NotificationInterface
{

    /**
     * @return User
     */
    public function getToUser(): User;

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @return string
     */
    public function getTemplate();

    /**
     * @return bool
     */
    public function isAllowSendNotification(): bool;

    /**
     * @return array
     */
    public function getContent(): array;

    /**
     * @return string
     */
    public function getLoggerCategory();

    /**
     * @return string
     */
    public function getErrorMessage();

    /**
     * @return string
     */
    public function getSuccessMessage();

    public function afterAction();
}