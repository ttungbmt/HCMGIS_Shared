<?php
namespace Larabase\Relations\BelongsTo;

trait HcQuan
{
    public function quan()
    {
        return $this->belongsTo(\App\Models\HcQuan::class, 'maquan', 'maquan');
    }
}
