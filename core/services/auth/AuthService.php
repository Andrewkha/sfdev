<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/6/2018
 * Time: 1:17 PM
 */

namespace core\services\auth;


use core\entities\user\User;
use core\forms\auth\LoginForm;
use core\repositories\sf\UserRepository;

class AuthService
{
    public $users;
    public $tokens;

    public function __construct(UserRepository $users, TokensManager $tokens)
    {
        $this->users = $users;
        $this->tokens = $tokens;
    }

    public function login(LoginForm $form): User
    {
        $user = $this->users->findByUsernameOrEmail($form->username);

        if (!$user || !$user->isActive() || !$this->tokens->validatePassword($form->password, $user->password_hash)) {
            throw new \DomainException('Неверное имя пользователя или пароль');
        }

        $user->login($form->rememberMe);
        $this->users->save($user);

        return $user;
    }
}