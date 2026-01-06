<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Hearing extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Hearing>
     */
    public static $model = \App\Models\Hearing::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'type';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'type',
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

            BelongsTo::make('Tenant', 'tenant', Tenant::class)->sortable(),
            BelongsTo::make('Case', 'case', LegalCase::class)->sortable(),

            Text::make('Type')->sortable(),
            DateTime::make('Scheduled At')->sortable(),

            Number::make('Duration (Min)', 'duration_minutes'),

            Badge::make('Status')->map([
                'programada' => 'info',
                'celebrada' => 'success',
                'cancelada' => 'danger',
                'reprogramada' => 'warning',
            ]),

            Text::make('Courtroom')->hideFromIndex(),
        ];
    }
}
