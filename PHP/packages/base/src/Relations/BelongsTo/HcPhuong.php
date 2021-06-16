<?php

namespace Larabase\Relations\BelongsTo;

trait HcPhuong
{
    public function phuong(){
        return $this->belongsTo(\App\Models\HcPhuong::class, 'maphuong', 'maphuong');
    }
}
