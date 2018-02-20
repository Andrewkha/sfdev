<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/20/2018
 * Time: 2:07 PM
 */

namespace core\entities\user;


class UserData
{
    public $username;
    public $email;
    public $first_name;
    public $last_name;

    public function __construct($username, $email, $first_name, $last_name)
    {
        $this->username = $username;
        $this->email = $email;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }
}