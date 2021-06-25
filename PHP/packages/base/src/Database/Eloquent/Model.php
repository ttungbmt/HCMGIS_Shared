<?php
namespace Larabase\Database\Eloquent;

use Larabase\Database\Eloquent\Relations\HasMany;
use Larabase\Database\Eloquent\Relations\HasOne;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected function newHasMany(\Illuminate\Database\Eloquent\Builder $query, \Illuminate\Database\Eloquent\Model $parent, $foreignKey, $localKey)
    {
        return new HasMany($query, $parent, $foreignKey, $localKey);
    }

    protected function newHasOne(\Illuminate\Database\Eloquent\Builder $query, \Illuminate\Database\Eloquent\Model $parent, $foreignKey, $localKey)
    {
        return new HasOne($query, $parent, $foreignKey, $localKey);
    }

    public static function table(){
        return with(new static)->table;
    }
}