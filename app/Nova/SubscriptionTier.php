<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class SubscriptionTier extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\SubscriptionTier>
     */
    public static $model = \App\Models\SubscriptionTier::class;

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

            Text::make('Slug')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:subscription_tiers,slug')
                ->updateRules('unique:subscription_tiers,slug,{{resourceId}}'),

            Textarea::make('Description')
                ->alwaysShow(),

            Currency::make('Monthly Price', 'price_monthly')
                ->resolveUsing(fn($v) => $v / 100)
                ->fillUsing(fn($req, $model, $attr) => $model->{$attr} = $req->{$attr} * 100),

            Currency::make('Yearly Price', 'price_yearly')
                ->resolveUsing(fn($v) => $v / 100)
                ->fillUsing(fn($req, $model, $attr) => $model->{$attr} = $req->{$attr} * 100),

            Number::make('Max Users'),
            Number::make('Max Storage (GB)', 'max_storage_gb'),
            Number::make('Max Active Cases', 'max_active_cases'),

            KeyValue::make('Features'),

            Boolean::make('Is Active'),
            Number::make('Sort Order')->sortable(),
        ];
    }
}
