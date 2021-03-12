<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Tests\Feature\Nova;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;
use Tipoff\Authorization\Tests\TestCase;

class UserResourceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index()
    {
        User::factory()->count(4)->create();

        $this->actingAs(self::createPermissionedUser('view users', true));

        $response = $this->getJson('nova-api/users')
            ->assertOk();

        $this->assertCount(4, $response->json('resources'));
    }

    /** @test */
    public function show()
    {
        $user = User::factory()->create();

        $this->actingAs(self::createPermissionedUser('view users', true));

        $response = $this->getJson("nova-api/users/{$user->id}")
            ->assertOk();

        $this->assertEquals($user->id, $response->json('resource.id.value'));
    }
}
