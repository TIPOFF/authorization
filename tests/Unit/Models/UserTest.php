<?php

namespace Tipoff\Authorization\Tests\Unit\Models;

use Tipoff\Checkout\Models\Cart;
use Tipoff\Authorization\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Tipoff\Authorization\Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @group Cart
     * @test
     */
    public function the_cart_method_should_create_a_new_cart_if_there_is_none()
    {
        $user = User::factory()->create();

        $this->assertCount(0, $user->carts);

        $this->assertInstanceOf(Cart::class, $user->cart());
    }

    /**
     * @group Cart
     * @test
     */
    public function the_cart_method_should_create_a_new_cart_if_there_are_none_active()
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'expires_at' => Carbon::now()->subMinute(),
        ]);

        $this->assertCount(1, $user->carts);

        $this->assertNotEquals($cart->id, $user->cart()->id);
    }

    /**
     * @group Cart
     * @test
     */
    public function the_cart_method_should_return_the_first_active_cart()
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'expires_at' => Carbon::now()->addMinute(),
        ]);

        $this->assertCount(1, $user->carts);

        $this->assertEquals($cart->id, $user->cart()->id);
    }
}
