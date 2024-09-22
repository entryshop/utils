<?php

namespace Entryshop\Utils\Models\Traits;

trait HasDefaultRecord
{
    public function scopeDefault($query, $default = true)
    {
        $query->whereDefault($default);
    }

    public static function getDefault()
    {
        return self::query()->default(true)->first();
    }
}
