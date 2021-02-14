<?php

declare(strict_types=1);

namespace Tipoff\Authorization;

use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class AuthorizationServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->name('authorization')
            ->hasConfigFile();
    }
}
