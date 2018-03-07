<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/7/2018
 * Time: 2:50 PM
 */

namespace core\entities\user\events;


use core\entities\user\User;

class PasswordResetRequestSubmitted
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}