<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Tests;

use Laravel\Nova\NovaCoreServiceProvider;
use Spatie\Permission\PermissionServiceProvider;
use Tipoff\Authorization\AuthorizationServiceProvider;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\Authorization\Tests\Support\Providers\NovaPackageServiceProvider;
use Tipoff\TestSupport\BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            PermissionServiceProvider::class,
            AuthorizationServiceProvider::class,
            NovaCoreServiceProvider::class,
            NovaPackageServiceProvider::class,
        ];
    }
}
