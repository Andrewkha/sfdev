<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/22/2018
 * Time: 1:49 PM
 */

namespace core\repositories\sf;

use core\dispatchers\EventDispatcher;
use core\entities\user\User;
use yii\web\NotFoundHttpException;

class UserRepository
{

    private $eventDispatcher;

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function get($id): User
    {
        if (!$user = User::findOne($id)) {
            throw new NotFoundHttpException('Такого пользователя нет' );
        }

        return $user;
    }

    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new \RuntimeException('Ошибка сохранения');
        }

        $this->eventDispatcher->dispatchAll($user->releaseEvents());
    }

    public function remove(User $user): void
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Ошибка сохранения пользователя в базу');
        }

        $this->eventDispatcher->dispatchAll($user->releaseEvents());
    }

    public function getByEmailConfirmToken($token): User
    {
        /** @var User $user */
        if (!$user = User::find()->where(['email_confirm_token' => $token])->one()) {
            throw new NotFoundHttpException('Произошла ошибка. Обратитесь к администрации' );
        }

        return $user;
    }

    public function getByPasswordResetToken($token): ?User
    {
        return User::findOne(['password_reset_token' => $token]);
    }

    public function findByUsernameOrEmail($string): ?User
    {
        return User::find()->where(['or', ['username' => $string], ['email' => $string]])->one();
    }
}