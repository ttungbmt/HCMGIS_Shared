<?php

namespace Larabase\Relations\HasMany;

trait HcQuan
{
    public function quans()
    {
        return $this->hasMany(\App\Models\HcQuan::class, 'ma_tp', 'ma_tp');
    }
}
