<?php

declare(strict_types=1);

namespace Tipoff\Authorization;

use Tipoff\Authorization\Models\User;
use Tipoff\Authorization\Policies\UserPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class AuthorizationServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                User::class => UserPolicy::class,
            ])
            ->hasNovaResources([
                \Tipoff\Authorization\Nova\User::class,
            ])
            ->name('authorization')
            ->hasConfigFile();
    }
}
