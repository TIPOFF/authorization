<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Tests\Support\Providers;

use Tipoff\Authorization\Nova\User;
use Tipoff\TestSupport\Providers\BaseNovaPackageServiceProvider;

class NovaPackageServiceProvider extends BaseNovaPackageServiceProvider
{
    public static array $packageResources = [
        User::class,
    ];
}
