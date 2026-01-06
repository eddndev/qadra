<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class HearingType extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\HearingType>
     */
    public static $model = \App\Models\HearingType::class;

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
        'slug',
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

            Slug::make('Slug')
                ->from('Name')
                ->rules('required', 'max:255')
                ->creationRules('unique:hearing_types,slug')
                ->updateRules('unique:hearing_types,slug,{{resourceId}}'),

            Textarea::make('Description')
                ->alwaysShow(),
        ];
    }
}
