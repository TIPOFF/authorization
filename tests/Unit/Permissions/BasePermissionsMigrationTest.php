<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Tests\Unit\Permissions;

use Tipoff\Authorization\Permissions\BasePermissionsMigration;
use Tipoff\Authorization\Tests\TestCase;

class BasePermissionsMigrationTest extends TestCase
{
    /** @test */
    public function permission_array_is_prepared_properly()
    {
        $migrator = new BasePermissionsMigration();

        $result = $migrator->preparePermissions(['a', 'b', 'c']);
        $this->assertEquals([
            'a' => [],
            'b' => [],
            'c' => [],
        ], $result);

        $result = $migrator->preparePermissions([
            'a' => [],
            'b' => [],
            'c' => [],
        ]);
        $this->assertEquals([
            'a' => [],
            'b' => [],
            'c' => [],
        ], $result);

        $result = $migrator->preparePermissions([
            'a' => ['a', 'b'],
            'b' => ['c', 'd'],
            'c' => [],
        ]);
        $this->assertEquals([
            'a' => ['a', 'b'],
            'b' => ['c', 'd'],
            'c' => [],
        ], $result);
    }

    /** @test */
    public function permission_records_are_built_properly()
    {
        $migrator = new BasePermissionsMigration();

        $result = $migrator->buildPermissionRecords([
            'a' => [],
            'b' => [],
            'c' => [],
        ]);
        $this->assertEquals([
            ['name' => 'a', 'guard_name' => 'web'],
            ['name' => 'b', 'guard_name' => 'web'],
            ['name' => 'c', 'guard_name' => 'web'],
        ], $result);

        $result = $migrator->buildPermissionRecords([
            'a' => ['a', 'b'],
            'b' => ['c', 'd'],
            'c' => [],
        ]);
        $this->assertEquals([
            ['name' => 'a', 'guard_name' => 'web'],
            ['name' => 'b', 'guard_name' => 'web'],
            ['name' => 'c', 'guard_name' => 'web'],
        ], $result);
    }

    /** @test */
    public function role_permissions_are_build_properly()
    {
        $migrator = new BasePermissionsMigration();

        $result = $migrator->buildRolePermissions([
            'a' => [],
            'b' => [],
            'c' => [],
        ]);
        $this->assertEquals([
            'Admin' => ['a', 'b', 'c'],
        ], $result);

        $result = $migrator->buildRolePermissions([
            'a' => ['a', 'b'],
            'b' => ['b', 'c'],
            'c' => [],
        ]);
        $this->assertEquals([
            'Admin' => ['a', 'b', 'c'],
            'a' => ['a'],
            'b' => ['a', 'b'],
            'c' => ['b'],
        ], $result);
    }
}
