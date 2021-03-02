<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Tests\Unit\Policies;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;
use Tipoff\Authorization\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class UserPolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view users', true);
        $this->assertTrue($user->can('viewAny', User::class));

        $user = self::createPermissionedUser('view users', false);
        $this->assertFalse($user->can('viewAny', User::class));
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_as_creator
     */
    public function all_permissions_as_creator(string $permission, UserInterface $user, bool $expected)
    {
        $target = User::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $target));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view users', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view users', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create users', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create users', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update users', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update users', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete users', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete users', false), false ],
        ];
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_not_creator
     */
    public function all_permissions_not_creator(string $permission, UserInterface $user, bool $expected)
    {
        $target = User::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $target));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
