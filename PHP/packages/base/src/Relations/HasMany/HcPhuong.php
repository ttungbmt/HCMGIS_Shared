<?php

namespace Larabase\Relations\HasMany;

trait HcPhuong
{
    public function phuongs()
    {
        return $this->hasMany(\App\Models\HcPhuong::class, 'maquan', 'maquan');
    }
}
