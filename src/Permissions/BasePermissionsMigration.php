<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Permissions;

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class BasePermissionsMigration extends Migration
{
    private static array $roles = [];
    
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
                    $roles = [];
                }
                
                Permission::findOrCreate($permission);
                $this->givePermissionToRole($permission, 'Admin');
                foreach (array_unique($roles) as $role) {
                    $this->givePermissionToRole($permission, $role);
                }
            }
            /** @psalm-suppress UndefinedMethod */
            app(PermissionRegistrar::class)->forgetCachedPermissions();
        }
    }

    public function givePermissionToRole(string $permission, string $roleName)
    {
        if ($role = $this->getRole($roleName)) {
            $role->givePermissionTo($permission);
        }
    }
    
    private function getRole(string $roleName): ?Role
    {
        if (! array_key_exists($roleName, self::$roles)) {
            self::$roles[$roleName] = Role::findByName($roleName);
        }

        /** @var Role $role */
        $role = self::$roles[$roleName];
        
        return $role;
    }
}
