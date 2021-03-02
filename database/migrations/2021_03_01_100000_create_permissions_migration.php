<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;

class CreatePermissionsMigration extends Migration
{
    public function up()
    {
        if (app()->has(Permission::class)) {
            $adminRole = Role::findByName('Admin');

            app(PermissionRegistrar::class)->forgetCachedPermissions();
            $permissions = [
                'view users',
                'create users',
                'update users',
            ];

            foreach ($permissions as $permission) {
                app(Permission::class)::findOrCreate($permission, null);
                $adminRole->givePermissionTo($permission);
            }
        }
    }
}
