<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Tests\Unit\Http\Controllers;

use Tipoff\Authorization\Tests\TestCase;

abstract class ControllerTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Work around for not being able to pull in support as a direct dependency
        $this->app->make('view')->addNamespace('support', __DIR__ . '/../../../resources/views');
    }
}
