<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tipoff\Authorization\Models\EmailAddress;
use Tipoff\Authorization\Models\User;
use Tipoff\Authorization\Tests\TestCase;

class AuthenticationControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index_not_logged_in()
    {
        $this->get(route('authorization.login'))
            ->assertOk();
    }

    /** @test */
    public function index_logged_in_email()
    {
        $this->actingAs(EmailAddress::factory()->create(), 'email');

        $this->get(route('authorization.login'))
            ->assertOk();
    }

    /** @test */
    public function index_logged_in_web()
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('authorization.login'))
            ->assertRedirect();
    }

    /** @test */
    public function store()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->post(route('authorization.login'), [
            'username' => $user->username,
            'password' => 'password',
        ])->assertRedirect('/');

        $this->assertTrue(Auth::guard('web')->check());
        $this->assertFalse(Auth::guard('email')->check());
    }
}
