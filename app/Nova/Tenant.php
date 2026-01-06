<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Tenant extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Tenant>
     */
    public static $model = \App\Models\Tenant::class;

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
        'tax_id',
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

            Text::make('Slug')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:tenants,slug')
                ->updateRules('unique:tenants,slug,{{resourceId}}'),

            Text::make('Tax ID', 'tax_id')
                ->hideFromIndex(),

            BelongsTo::make('Subscription Tier', 'subscriptionTier', SubscriptionTier::class)
                ->sortable(),

            Badge::make('Status')->map([
                'active' => 'success',
                'inactive' => 'danger',
                'suspended' => 'warning',
            ]),

            DateTime::make('Trial Ends At')
                ->sortable(),

            DateTime::make('Subscription Ends At')
                ->sortable(),

            DateTime::make('Created At')
                ->onlyOnDetail(),
        ];
    }
}
