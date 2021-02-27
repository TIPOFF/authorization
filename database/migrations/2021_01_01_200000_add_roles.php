<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\RoleRegistrar;

class AddRoles extends Migration
{
    public function up()
    {
        if (app()->has(Role::class)) {
            app(RoleRegistrar::class)->forgetCachedPermissions();

            foreach ([
                'Admin',
                'Owner',
                'Staff',
                'Former Staff',
                'Customer',
            ] as $name) {
                app(Role::class)::findOrCreate($name, null);
            };
        }
    }
}
