<?php

namespace Tipoff\Authorization\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\EmailAddress;
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
}
