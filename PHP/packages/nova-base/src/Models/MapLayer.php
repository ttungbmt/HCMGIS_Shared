<?php

namespace Larabase\Nova\Models;

use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Larabase\Database\Eloquent\Model;

class MapLayer extends Model
{
    use SchemalessAttributesTrait;

    protected $table = 'maps_maplayer';

    protected $fillable = ['map_id', 'stack_order', 'format', 'name', 'opacity', 'styles', 'transparent', 'group', 'visibility', 'url', 'data', 'params', 'options', 'popup', 'local',];

    protected $casts = [
        'data' => 'array',
        'params' => 'array',
        'options' => 'array',
    ];

    protected $schemalessAttributes = [
        'popup',
    ];

}
