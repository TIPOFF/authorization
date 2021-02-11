<?php

declare(strict_types=1);

namespace Tipoff\Authorization;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AuthorizationServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        parent::boot();
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('authorization')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        $this->publishes([
            __DIR__.'/../config/permission.php' => config_path('permission.php'),
        ]);
    }
}
