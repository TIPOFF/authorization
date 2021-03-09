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
            /*
             * allow for permissions to be:
             * 1. permission => [...roles],
             * 2. permission => [],  (empty array)
             * 3. permission string without value (for backward compat)
             */
            foreach ($permissions as $permission => $roles) {
                if (is_numeric($permission)) {    // it doesn't have a role; the role is the permission
                    $permission = $roles;       // swap key and value
                    $this->givePermissionToAdmin($permission);
                } else {
                    foreach ($roles as $role) {
                        if ($Role = Role::findByName($role)) {
                            $this->givePermissionToAdmin($permission);
                            $Role->givePermissionTo($permission);
                        }
                    }
                }
            }
            /** @psalm-suppress UndefinedMethod */
            app(PermissionRegistrar::class)->forgetCachedPermissions();
        }
    }

    public function givePermissionToAdmin($permission)
    {
        $adminRole = Role::findByName('Admin');
        /** @psalm-suppress UndefinedMethod */
        app(Permission::class)::findOrCreate($permission, null);
        // assign to admin if doesn't have
        if (! $adminRole->hasPermissionTo($permission)) {
            $adminRole->givePermissionTo($permission);
        }
    }
}
