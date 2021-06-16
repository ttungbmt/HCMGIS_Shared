<?php
namespace Larabase\Relations\BelongsTo;

trait HcTp
{
    public function tp()
    {
        return $this->belongsTo(\App\Models\HcTp::class, 'ma_tp', 'ma_tp');
    }
}
