<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/20/2018
 * Time: 4:07 PM
 */

namespace core\entities\user\events;

use core\entities\user\User;

/*
 * Send a user a note to reset a password, which will active the account as well
 */

class UserCreatedByAdmin
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}