<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddUserPermissionsMigration extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'view users',
            'create users',
            'update users',
        ];

        $this->createPermissions($permissions);
    }
}
