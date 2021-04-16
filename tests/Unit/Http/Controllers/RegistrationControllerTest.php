<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tipoff\Authorization\Models\EmailAddress;
use Tipoff\Authorization\Models\User;

class RegistrationControllerTest extends ControllerTestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index_not_logged_in()
    {
        $this->get(route('authorization.register'))
            ->assertOk();
    }

    /** @test */
    public function index_logged_in_email()
    {
        $this->actingAs(EmailAddress::factory()->create(), 'email');

        $this->get(route('authorization.register'))
            ->assertOk();
    }

    /** @test */
    public function index_logged_in_web()
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('authorization.register'))
            ->assertRedirect();
    }

    /** @test */
    public function store()
    {
        $this->post(route('authorization.register'), [
            'first_name' => 'first',
            'last_name' => 'last',
            'email' => 'email@example.com',
            'username' => 'username',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect('/');

        $this->assertEquals(1, User::query()->where('username', 'username')->count());
        $this->assertTrue(Auth::guard('web')->check());
        $this->assertFalse(Auth::guard('email')->check());
    }
}
