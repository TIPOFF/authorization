<?php

namespace Tipoff\Authorization\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\EmailAddress;
use Tipoff\Authorization\Models\User;
use Tipoff\Authorization\Tests\TestCase;

class EmailAddressTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $email = EmailAddress::factory()->create();
        $this->assertNotNull($email);
    }

    /** @test */
    public function act_as()
    {
        $email = EmailAddress::factory()->create();

        $this->assertFalse($this->isAuthenticated('web'));
        $this->assertFalse($this->isAuthenticated('email'));

        $this->actingAs($email, 'email');

        $this->assertFalse($this->isAuthenticated('web'));
        $this->assertTrue($this->isAuthenticated('email'));
    }

    /** @test*/
    public function user_can_have_multiple_emails()
    {
        $user = User::factory()->create();
        $user->emailAddresses()->save(EmailAddress::factory()->create());
        $user->emailAddresses()->save(EmailAddress::factory()->create());

        $this->assertEquals(2, $user->emailAddresses()->count());
    }

    /** @test*/
    public function email_address_can_be_primary()
    {
        $user = User::factory()->create();
        $user->emailAddresses()->save(EmailAddress::factory()->create(['primary' => true]));

        $this->assertNotNull($user->getPrimaryEmailAddress());
    }

    /** @test*/
    public function get_user_from_email()
    {
        $email = EmailAddress::factory()->create();
        $email->user()->associate(User::factory()->create());

        $this->assertNotNull($email->user);
    }

    /** @test */
    public function get_auth_password()
    {
        $email = EmailAddress::factory()->create();

        $this->assertEquals('', $email->getAuthPassword());
    }
}
