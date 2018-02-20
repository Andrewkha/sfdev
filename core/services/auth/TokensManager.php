<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/20/2018
 * Time: 3:22 PM
 */

namespace core\services\auth;


use yii\base\Security;

class TokensManager
{
    private $security;
    private $timeout;

    public function __construct(Security $security, $timeout)
    {
        $this->security = $security;
        $this->timeout = $timeout;
    }

    public function generateToken(): string
    {
        return $this->generateRandomString() . '_' . time();
    }

    public function validateToken($token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        return $timestamp + $this->timeout >= time();
    }

    public function generatePassword($password = null): string
    {
        $password = ($password) ? $password : $this->generateRandomString();
        return $this->security->generatePasswordHash($password);
    }

    public function generateRandomString(): string
    {
        return $this->security->generateRandomString();
    }
}