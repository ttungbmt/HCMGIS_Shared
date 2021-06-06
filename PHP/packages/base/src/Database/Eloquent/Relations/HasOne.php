<?php
namespace Larabase\Database\Eloquent\Relations;

use Illuminate\Support\Arr;

class HasOne extends \Illuminate\Database\Eloquent\Relations\HasOne
{
    public function sync($values, $detaching = true){
        if($values->isEmpty()){
            $this->delete();
        } else {
            $foreignKey = $this->getForeignKeyName();
            $data = $values->isAssoc() ? $values : $values->first();
            $model = $this->first() ?: $this->getRelated();

            $model->fill($data);
            $model->{$foreignKey} = $this->getParentKey();
            $model->save();
        }
    }
}