<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tipoff\Authorization\Models\User;
use Tipoff\Authorization\Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /** @test */
    public function create()
    {
        $model = User::factory()->create();
        $this->assertNotNull($model);
    }
}
