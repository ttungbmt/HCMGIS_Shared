<?php

namespace Larabase\Nova\Resources;

use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Larabase\NovaFields\Integer;
use Larabase\NovaFields\KeyValue;
use Larabase\NovaFields\Radio;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use phpDocumentor\Reflection\Types\Void_;

class MapLayer extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Larabase\Nova\Models\MapLayer::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static $dir = [];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    public function __construct($resource)
    {
        parent::__construct($resource);

        static::$dir['services'] = \Larabase\Nova\Models\MapService::pluck('name', 'id');
        static::$dir['srv_ids'] = \Larabase\Nova\Models\MapService::whereIn('type', ['OWS', 'WMS', 'WMTS'])->pluck('id');
    }


    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        $formats = ['image/png', 'image/jpeg', 'image/gif', 'image/gif;subtype=animated', 'image/png8', 'image/png; mode=8bit'];

        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Name', 'name'),

            Select::make('Service', 'data->service')->options(static::$dir['services'])->displayUsingLabels()->nullable(),

            Radio::make('Control', 'data->control')->options(['basemap' => 'Basemap', 'overlay' => 'Overlay'])->rules('required'),

            NovaDependencyContainer::make([
                Select::make('Type', 'data->type')->options(MapService::$dir['types'])->displayUsingLabels()->rules('required_if:data->service,null'),
                NovaDependencyContainer::make([
                    Text::make('Url', 'url'),
                    Text::make('Layers', 'options->layers'),
                    KeyValue::make('Params', 'params'),
                ])
                    ->dependsOnInclude('data->type', ['OWS', 'WMS', 'WMTS']),
            ])->dependsOnEmpty('data->service'),


            NovaDependencyContainer::make([
                Text::make('Layers', 'options->layers')->rules('required'),
                KeyValue::make('Params', 'params'),
                Text::make('Styles', 'styles'),
                Number::make('Opacity', 'opacity')->min(0)->max(1)->step(1e-3),
                Select::make('Format', 'format')->options(array_combine($formats, $formats)),
                Boolean::make('Transparent', 'transparent'),
            ])->dependsOnInclude('data->service', static::$dir['srv_ids']),

            KeyValue::make('Options', 'options')
                ->resolveUsing(function ($value) {
                    return collect($value)->except(['layers', 'format', 'opacity', 'transparent'])->all();
                })
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    $model->{$attribute} = array_merge(json_decode($request[$requestAttribute], true), collect($model->options)->only([
                        'layers', 'format', 'opacity', 'transparent'
                    ])->all());
                }),


            Integer::make('Count', 'data->count'),

            new Panel('Popup', [
                Boolean::make('Enabled', 'popup_enabled')->resolveUsing(function ($value) {
                    return !empty($this->popup);
                })->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    if (!$request->exists('popup->fields')) $model->popup = null;
                }),
                NovaDependencyContainer::make([
                    Radio::make('Type', 'popup->type')
                        ->options([
                            'table' => 'Table',
                            'html' => 'HTML',
                            'json' => 'JSON',
                        ])
                        ->marginBetween(),
                    NovaDependencyContainer::make([
                        Text::make('Heading', 'popup->heading'),

                        KeyValue::make('Fields', 'popup->fields')->keyLabel('attribute')->valueLabel('label')
                            ->resolveUsing(function ($value) {
                                return empty($value) ? [] : collect($value)->pluck('label', 'attribute')->all();
                            })
                            ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                                if ($request->exists($attribute)) {
                                    $fields = $this->toFields(json_decode($request[$requestAttribute], true));
                                    $model->popup['fields'] = $fields;
                                }
                            })
                    ])->dependsOn('popup->type', 'table'),

                    NovaDependencyContainer::make([
                        Code::make('HTML', 'popup->html')->language('php')
                    ])->dependsOn('popup->type', 'html'),

                    NovaDependencyContainer::make([
                        Code::make('JSON', 'popup->jsonFields')->language('application/json')->json()
                    ])->dependsOn('popup->type', 'json'),

                    Code::make('Actions', 'popup->actions')->language('application/json')->resolveUsing(function ($value){
                        return json_decode($value) ? $value : null;
                    })->json(),
                ])->dependsOnNotEmpty('popup_enabled'),
            ])
        ];
    }

    protected function toFields($keyValue)
    {
        return collect($keyValue)->map(fn($v, $k) => ['label' => $v, 'attribute' => $k])->values()->all();
    }

//    public static function beforeSave(Request $request, $model)
//    {
//        dd($request->all(), $model);
//    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
