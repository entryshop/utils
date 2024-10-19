<?php

namespace Entryshop\Utils\Models\Traits;

use Illuminate\Support\Str;

/**
 * @property static $reference_prefix
 */
trait HasReference
{

    protected static function bootHasReference()
    {
        static::creating(function ($model) {
            if (empty($model->reference)) {
                $model->reference = static::getReferencePrefix($model) . Str::ulid();
            }
        });
    }

    public static function getReferencePrefix($model)
    {
        return $model->reference_prefix ?? Str::lower(class_basename(static::class)) . '_';
    }
}
