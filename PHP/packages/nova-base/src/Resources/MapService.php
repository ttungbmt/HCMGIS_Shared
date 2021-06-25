<?php

namespace Larabase\Nova\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class MapService extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Larabase\Nova\Models\MapService::class;

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
        'name',
    ];

    public static $dirs = [
        'types' => [
            'AUTO' => 'Auto-detect',
            'AJAX' => 'Ajax Layer',
            'MARKER-CLUSTER' => 'Marker Cluster',
            'GEOJSON' => 'GeoJSON Layer',
            'TILE' => 'Tile Layer',
            'OWS' => 'OWS OGC Web Service',
            'WMS' => 'WMS OGC Web Service',
            'WMTS' => 'WMTS OGC Web Service',
            'WFS' => 'WFS OGC Web Service',
            'CSW' => 'CWS OGC Service',
            'REST' => 'ArcGIS REST Service',
            'OGP' => 'OpenGeoPortal',
            'HGL' => 'Harvard Geospatial Library',
        ]
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Select::make('Type', 'type')->options(static::$dirs['types'])->displayUsingLabels()->default('AUTO'),
            Text::make(__('Name'), 'name')->sortable()->rules('required'),
            Text::make(__('Description'), 'description')->hideFromIndex(),
            Text::make(__('Url'), 'base_url')->displayUsing(function ($value){
                return Str::startsWith($value, 'http') ? $value : url($value);
            })->rules('required')->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
