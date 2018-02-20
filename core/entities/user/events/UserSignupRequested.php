<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/20/2018
 * Time: 4:07 PM
 */

namespace core\entities\user\events;

use core\entities\user\User;

class UserSignupRequested
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}