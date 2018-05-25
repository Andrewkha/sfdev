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
     * @return User[]
     */
    public function getToUsers();

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @return string
     */
    public function getTemplate();

    /**
     * @param User $user
     * @return bool
     */
    public function isAllowSendNotification(User $user): bool;

    /**
     * @param User $user
     * @return array
     */
    public function getContent(User $user): array;

    /**
     * @return string
     */
    public function getLoggerCategory();

    /**
     * @param string $username
     * @return string
     */
    public function getErrorMessage($username);

    /**
     * @param string $username
     * @return string
     */
    public function getSuccessMessage($username);
}