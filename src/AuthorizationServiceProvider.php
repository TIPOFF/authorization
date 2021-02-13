<?php

declare(strict_types=1);

namespace Tipoff\Authorization;

use Tipoff\Authorization\Models\Authorization;
use Tipoff\Authorization\Policies\AuthorizationPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class AuthorizationServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Authorization::class => AuthorizationPolicy::class,
            ])
            ->name('authorization')
            ->hasConfigFile();
    }
}
