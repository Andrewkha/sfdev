<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 11.03.2018
 * Time: 13:14
 */

namespace console\controllers;


use core\access\Rbac;
use yii\console\Controller;

class RbacInit extends Controller
{
    public function actionInit(): void
    {
        $am = $this->manager;
        $am->removeAll();

        $user = $am->createRole(Rbac::ROLE_USER);
        $user->description = 'Regular site user';
        $am->add($user);

        $admin = $am->createRole(Rbac::ROLE_ADMIN);
        $admin->description = 'Site administrator';
        $am->add($admin);

        $am->addChild($admin, $user);
    }
}