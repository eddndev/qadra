<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class DeadlineType extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\DeadlineType>
     */
    public static $model = \App\Models\DeadlineType::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Number::make('Default Days')
                ->sortable()
                ->rules('required', 'numeric'),

            Boolean::make('Business Days'),

            Textarea::make('Legal Basis')
                ->alwaysShow(),
        ];
    }
}
