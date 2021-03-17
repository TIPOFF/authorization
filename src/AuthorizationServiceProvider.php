<?php

declare(strict_types=1);

namespace Tipoff\Authorization;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Tipoff\Authorization\Models\User;
use Tipoff\Authorization\Policies\PermissionPolicy;
use Tipoff\Authorization\Policies\RolePolicy;
use Tipoff\Authorization\Policies\UserPolicy;
use Tipoff\Support\Contracts\Models\UserInterface;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;
use Tipoff\BookingCalendar\BookingCalendar;

class AuthorizationServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                User::class => UserPolicy::class,
            ])
            ->hasNovaResources([
                \Tipoff\Authorization\Nova\AlternateEmail::class,
                \Tipoff\Authorization\Nova\User::class,
            ])
            ->hasNovaTools([
                \Vyuldashev\NovaPermission\NovaPermissionTool::make()
                    ->rolePolicy(RolePolicy::class)
                    ->permissionPolicy(PermissionPolicy::class),
                (new BookingCalendar)::make()
                    ->canSee(function ($request) {
                        return $request->user()->can('view booking calendar');
                    }),
            ])
            ->name('authorization')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        Nova::booted(function () {
            // Register serving function only after Nova is booted, this should
            // ensure we are "last in line" and able to replace the default gate definition
            Nova::serving(function () {
                Gate::define('viewNova', function ($user) {
                    if ($user instanceof UserInterface) {
                        return app()->environment('testing') ||
                            $user->hasPermissionTo('access admin');
                    }

                    return false;
                });
            });
        });
    }
}
