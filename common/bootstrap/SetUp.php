<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/16/2018
 * Time: 5:51 PM
 */

namespace common\bootstrap;


use core\services\auth\TokensManager;
use yii\base\BootstrapInterface;
use yii\rbac\ManagerInterface;

class SetUp implements BootstrapInterface

{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(TokensManager::class, [], [
            \Yii::$app->security,
            $app->params['user.passwordTokenExpire']
        ]);

        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->authManager;
        });
    }
}