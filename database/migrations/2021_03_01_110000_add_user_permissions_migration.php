<?php

declare(strict_types=1);

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
