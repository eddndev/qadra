<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class LegalCase extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\LegalCase>
     */
    public static $model = \App\Models\LegalCase::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'case_alias';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'internal_folio',
        'case_alias',
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

            Text::make('Internal Folio')->sortable(),
            Text::make('Case Alias')->sortable(),

            Badge::make('Status')->map([
                'activo' => 'success',
                'cerrado' => 'danger',
                'suspendido' => 'warning',
                'archivo_muerto' => 'info',
            ]),

            Date::make('Start Date')->sortable(),

            BelongsTo::make('Lead Lawyer', 'leadLawyer', User::class)->sortable(),
        ];
    }
}
