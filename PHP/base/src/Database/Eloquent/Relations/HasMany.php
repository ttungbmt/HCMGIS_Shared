<?php

namespace Larabase\Database\Eloquent\Relations;

class HasMany extends \Illuminate\Database\Eloquent\Relations\HasMany
{
    public function sync($values, $detaching = true){
        $localKey = $this->getLocalKeyName();
        $data = collect($values);

        $changes = [
            'attached' => [], 'detached' => [], 'updated' => [],
        ];

        $makeModel = function ($i) use ($localKey){
            $instance = $this->make($i);
            if(isset($i[$localKey]) && $i[$localKey]) $instance->{$localKey} = $i[$localKey];
            return $instance->toArray();
        };
        // Delete
        $changes['detached'] = $data->filter(fn($b) => isset($b[$localKey]))->map(fn($b) => $b[$localKey])->all();
        $detaching && $this->whereNotIn($localKey, $changes['detached'])->delete();

        // Create
        $changes['attached'] = $data->filter(fn($b) => !isset($b[$localKey]))->all();
        $this->createMany(collect($changes['attached'])->values()->map($makeModel)->all());

        // Update
        $changes['updated'] = $data->filter(fn($b) => isset($b[$localKey]))->all();
        $this->upsert(collect($changes['updated'])->values()->map($makeModel)->all(), $localKey);

        return $changes;
    }
}
