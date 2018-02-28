<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/22/2018
 * Time: 1:49 PM
 */

namespace core\services\auth;


use core\access\Rbac;
use core\entities\user\User;
use core\entities\user\UserData;
use core\forms\auth\SignupForm;
use core\repositories\sf\UserRepository;
use core\services\RoleManager;
use core\services\TransactionManager;

class SignupService
{
    private $users;
    private $roles;
    private $transactions;
    private $tokens;

    public function __construct(UserRepository $users, RoleManager $roles, TransactionManager $transactions, TokensManager $tokens)
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->transactions = $transactions;
        $this->tokens = $tokens;
    }

    public function signup(SignupForm $form): void
    {
        $user = User::requestSignUp(
            new UserData(
                $form->username,
                $form->email,
                $form->firstName,
                $form->lastName
            ),
            $form->password,
            $form->notification,
            $form->avatar,
            $this->tokens
        );

        $this->transactions->wrap(function () use ($user) {
            $this->users->save($user);
            $this->roles->assign($user->id, Rbac::ROLE_USER);
        });
    }
}