<?php
namespace Larabase\Nova\Models;

use Larabase\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class MapMenuItems extends Model
{
    use NodeTrait;

    protected $table = 'map_menu_items';

    protected function getScopeAttributes()
    {
        return ['menu_id'];
    }
}
