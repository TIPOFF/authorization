<?php

namespace Tipoff\Authorization\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery\MockInterface;
use Tipoff\Authorization\Models\EmailAddress;
use Tipoff\Authorization\Models\User;
use Tipoff\Authorization\Tests\TestCase;
use Tipoff\Support\Contracts\Checkout\CartInterface;

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

    /** @test */
    public function get_cart_return_null()
    {
        $user = User::factory()->create();

        $this->assertNull($user->cart());
    }

    /** @test */
    public function get_cart()
    {
        $this->partialMock(CartInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('activeCart')
                    ->andReturn($mock);
        });

        $user = User::factory()->create();

        $this->assertInstanceOf(CartInterface::class, $user->cart());
    }

    /** @test */
    public function get_email_verified_at_attribute()
    {
        $user = User::factory()->create();

        $emailAddress = EmailAddress::factory()->verified()->create([
            'user_id' => $user,
        ]);

        $this->assertEquals($emailAddress->verified_at, $user->getEmailVerifiedAtAttribute());
    }
}
