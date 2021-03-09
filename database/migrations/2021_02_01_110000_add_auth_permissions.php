<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddAuthPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'access admin' => ['Owner','Staff','Customer'],
            'view users' => ['Owner','Staff'],
            'create users' => ['Owner','Staff'],
            'update users' => ['Owner'],
        ];

        $this->createPermissions($permissions);
    }
}
