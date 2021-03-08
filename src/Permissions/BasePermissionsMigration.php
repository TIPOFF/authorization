<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Permissions;

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class BasePermissionsMigration extends Migration
{
    public function createPermissions($permissions)
    {
        if (app()->has(Permission::class)) {
            $adminRole = Role::findByName('Admin');

            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ($permissions as $permission) {
                /** @psalm-suppress UndefinedMethod */
                app(Permission::class)::findOrCreate($permission, null);
                $adminRole->givePermissionTo($permission);
            }
        }
    }

    /**
     * General-purpose function to add a list of permissions to a particular role
     * Role passed as string name of role, eg. 'Owner', 'Customer', etc
     * - djfar
     * @param $permissions
     * @param $role
     */
    public function addPermissionsToRole($permissions, $role)
    {
        if (app()->has(Permission::class)) {
            $Role = Role::findByName($role);

            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ($permissions as $permission) {
                /** @psalm-suppress UndefinedMethod */
                app(Permission::class)::findOrCreate($permission, null);
                $Role->givePermissionTo($permission);
            }
        }
    }
}
