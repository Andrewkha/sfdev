<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/16/2018
 * Time: 5:51 PM
 */

namespace common\bootstrap;


use core\dispatchers\DeferredEventDispatcher;
use core\dispatchers\EventDispatcher;
use core\dispatchers\SimpleEventDispatcher;
use core\services\auth\TokensManager;
use yii\base\BootstrapInterface;
use yii\di\Container;
use yii\log\Logger;
use yii\mail\MailerInterface;
use yii\rbac\ManagerInterface;

class SetUp implements BootstrapInterface

{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(Logger::class, function () {
            return \Yii::getLogger();
        });

        $container->setSingleton(TokensManager::class, [], [
            \Yii::$app->security,
            $app->params['user.passwordTokenExpire']
        ]);

        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->authManager;
        });

        $container->setSingleton(MailerInterface::class, function ()  use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(EventDispatcher::class, DeferredEventDispatcher::class);

        $container->setSingleton(DeferredEventDispatcher::class, function (Container $container) {
            return new DeferredEventDispatcher(new SimpleEventDispatcher($container, [

            ]));
        });
    }
}