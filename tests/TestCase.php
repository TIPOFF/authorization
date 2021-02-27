<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Tests;

use Spatie\Permission\PermissionServiceProvider;
use Tipoff\Authorization\AuthorizationServiceProvider;
use Tipoff\Support\SupportServiceProvider;

class TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            PermissionServiceProvider::class,
            AuthorizationServiceProvider::class,
        ];
    }
}
