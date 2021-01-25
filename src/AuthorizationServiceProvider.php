<?php

namespace Tipoff\Authorization;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tipoff\Authorization\Commands\AuthorizationCommand;

class AuthorizationServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('authorization')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_authorization_table')
            ->hasCommand(AuthorizationCommand::class);
    }
}
