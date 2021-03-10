<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class AlternateEmail extends BaseResource
{
    public static $model = \Tipoff\Authorization\Models\AlternateEmail::class;

    public static $title = 'email';

    public static $search = [
        'id',
    ];

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Email')->required()->creationRules('unique:alternate_emails,email')->sortable(),
            nova('user') ? BelongsTo::make('User', 'user', nova('user'))->searchable() : null,

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function dataFields(): array
    {
        return array_merge(
            parent::dataFields(), 
            [
                DateTime::make('Created At')->exceptOnForms(),
                DateTime::make('Updated At')->exceptOnForms(),
            ]
        );
    }
}
