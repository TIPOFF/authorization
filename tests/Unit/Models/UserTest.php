<?php

namespace Tipoff\Authorization\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;
use Tipoff\Authorization\Tests\TestCase;
use Tipoff\Locations\Models\Location;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $user = User::factory()->create();
        $this->assertNotNull($user);
    }

    /** @test */
    public function custom_fields()
    {
        $user = User::factory()->create([
            'bio' => 'bio field',
            'title' => 'title field',
            'provider_name' => 'provider name field',
            'provider_id' => 'provider id field',
        ]);

        /** @var User $result */
        $result = User::findOrFail($user->id);

        $this->assertEquals('bio field', $result->bio);
        $this->assertEquals('title field', $result->title);
        $this->assertEquals('provider name field', $result->provider_name);
        $this->assertEquals('provider id field', $result->provider_id);
    }

    /** @test */
    public function soft_delete()
    {
        $user = User::factory()->create();

        $user->delete();

        $user->refresh();

        $this->assertNotNull($user->deleted_at);
    }
}
