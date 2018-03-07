<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/7/2018
 * Time: 2:37 PM
 */

namespace core\services\auth;


use core\exceptions\auth\EmptyPasswordResetTokenException;
use core\exceptions\auth\PasswordResetTokenExpiredException;
use core\exceptions\user\InactiveUserException;
use core\forms\auth\PasswordResetForm;
use core\forms\auth\PasswordResetRequestForm;
use core\repositories\sf\UserRepository;

class ResetService
{
    private $users;
    private $tokens;

    public function __construct(UserRepository $users, TokensManager $tokens)
    {
        $this->users = $users;
        $this->tokens = $tokens;
    }

    public function request(PasswordResetRequestForm $form): void
    {
        $user = $this->users->findByUsernameOrEmail($form->identity);

        if (!$user || !$user->isActive()) {
            throw new \DomainException('Нет активного пользователя с таким именем/email');
        }

        $user->requestPasswordReset($this->tokens);
        $this->users->save($user);
    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new EmptyPasswordResetTokenException('Токен восстановления пароля не может быть пустым');
        }

        if (!$this->tokens->validateToken($token)) {
            throw new PasswordResetTokenExpiredException('Срок действия токена истек, пожалуйста, перезапросите');
        }

        $user = $this->users->getByPasswordResetToken($token);

        if (!$user) {
            throw new EmptyPasswordResetTokenException('Некорректный токен');
        }

        if (!$user->isActive()) {
            throw new InactiveUserException('Ваша учетная запись неактивна, обратитесь к администрации');
        }
    }

    public function reset($token, PasswordResetForm $form)
    {
        $user = $this->users->getByPasswordResetToken($token);
        $user->resetPassword($form->password, $this->tokens);
        $this->users->save($user);
    }
}