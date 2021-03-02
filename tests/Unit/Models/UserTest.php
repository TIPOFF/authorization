<?php

namespace Tipoff\Authorization\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;
use Tipoff\Authorization\Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $user = User::factory()->create();
        $this->assertNotNull($user);
    }
}
