<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddAuthPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'access admin',
            'view users',
            'create users',
            'update users',
        ];

        $this->createPermissions($permissions);
    }
}
