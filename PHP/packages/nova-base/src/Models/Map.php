<?php
namespace Larabase\Nova\Models;

use Larabase\Database\Eloquent\Model;

class Map extends Model
{
    protected $table = 'maps_map';

    public $dates = ['published_at'];
}
