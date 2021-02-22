<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Vyuldashev\NovaPermission\PermissionBooleanGroup;
use Vyuldashev\NovaPermission\RoleBooleanGroup;

class User extends Resource
{
    public static $model = \Tipoff\Authorization\Models\User::class;

    public static $orderBy = ['id' => 'asc'];

    public static $title = 'full_name';

    public function subtitle()
    {
        return "ID: {$this->id} - {$this->email}";
    }

    public static $search = [
        'id',
        'name',
        'name_last',
        'email',
    ];

    public static $group = 'Access';

    public function fieldsForIndex(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Gravatar::make()->maxWidth(50),
            Text::make('First Name', 'name')->sortable(),
            Text::make('Last Name', 'name_last')->sortable(),
            Text::make('Email')->sortable(),
        ];
    }

    public function fields(Request $request)
    {
        return [
            Text::make('First Name', 'name')
                ->rules('required', 'max:255'),

            Text::make('Last Name', 'name_last')
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Gravatar::make()->maxWidth(50),

            Text::make('Bio'),
            Text::make('Title'),

            BelongsToMany::make('Locations'),

            HasMany::make('Customers', 'customers', app('customer')),
            HasMany::make('Participants', 'participants', app('participant')),

            HasMany::make('Managed Locations', 'managedLocations', app('location')),
            HasMany::make('Posts', 'posts', app('post')),
            HasMany::make('Vouchers Created', 'vouchersCreated', app('voucher')),
            HasMany::make('Blocks'),

            new Panel('Permissions', $this->permissionFields()),

            new Panel('Data Fields', $this->dataFields()),
        ];
    }

    protected function permissionFields()
    {
        return [
            RoleBooleanGroup::make('Roles')->canSee(function ($request) {
                return $request->user()->hasRole(['Admin', 'Owner', 'Executive', 'Reservation Manager']);
            }),
            PermissionBooleanGroup::make('Permissions')->canSee(function ($request) {
                return $request->user()->hasRole('Admin');
            }),
        ];
    }

    protected function dataFields()
    {
        return [
            ID::make(),
            DateTime::make('Created At')->exceptOnForms(),
            DateTime::make('Updated At')->exceptOnForms(),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }

    public function authorizedToForceDelete(Request $request)
    {
        return false;
    }
}
