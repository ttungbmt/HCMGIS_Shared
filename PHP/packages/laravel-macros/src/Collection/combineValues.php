<?php

use Illuminate\Support\Collection;

Collection::macro('combineValues', function (){
    return $this->mapWithKeys(fn($i) => [$i => $i]);
});