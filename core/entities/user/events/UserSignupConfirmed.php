<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/5/2018
 * Time: 5:36 PM
 */

namespace core\entities\user\events;

use core\entities\user\User;

class UserSignupConfirmed
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}