<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tipoff\Authorization\Models\EmailAddress;
use Tipoff\Authorization\Models\User;
use Tipoff\Authorization\Tests\TestCase;

class EmailAuthenticationControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index_not_logged_in()
    {
        $this->get(route('authorization.email-login'))
            ->assertOk();
    }

    /** @test */
    public function index_logged_in_email()
    {
        $this->actingAs(EmailAddress::factory()->create(), 'email');

        $this->get(route('authorization.email-login'))
            ->assertRedirect();
    }

    /** @test */
    public function index_logged_in_web()
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('authorization.email-login'))
            ->assertRedirect();
    }

    /** @test */
    public function store()
    {
        $this->post(route('authorization.email-login'), [
            'email' => 'email@example.com',
        ])->assertRedirect('/');

        $this->assertEquals(1, EmailAddress::query()->where('email', 'email@example.com')->count());
        $this->assertTrue(Auth::guard('email')->check());
    }
}
