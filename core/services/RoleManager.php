<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/20/2018
 * Time: 5:35 PM
 */

namespace core\services;


use yii\rbac\ManagerInterface;

class RoleManager
{
    private $manager;

    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function assign($userId, $roleName): void
    {
        if (!$role = $this->manager->getRole($roleName)) {
            throw new \DomainException('Роль "' . $roleName . '" не существует в системе"');
        }
        $this->manager->revokeAll($userId);
        $this->manager->assign($role, $userId);
    }
}