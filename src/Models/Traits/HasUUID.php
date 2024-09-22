<?php

namespace Entryshop\Utils\Models\Traits;

use Illuminate\Support\Str;

trait HasUUID
{
    public static function getUuidColumn()
    {
        return 'uuid';
    }

    public static function bootHasUUID()
    {
        static::creating(function ($model) {
            $uuid_column = static::getUuidColumn();
            if (empty($model->{$uuid_column})) {
                $model->{$uuid_column} = (string)Str::orderedUuid();
            }
        });
    }

    public static function findByUuid($uuid)
    {
        return static::query()->where(static::getUuidColumn(), $uuid)->first();
    }

}
