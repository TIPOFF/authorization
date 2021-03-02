<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Permissions;

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;

class BasePermissionsMigration extends Migration
{
    public function createPermissions($permissions)
    {
        if (app()->has(Permission::class)) {
            $adminRole = Role::findByName('Admin');

            app(PermissionRegistrar::class)->forgetCachedPermissions();
            
            foreach ($permissions as $permission) {
                app(Permission::class)::findOrCreate($permission, null);
                $adminRole->givePermissionTo($permission);
            }
        }
    }
}
