<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UsesUuid
{

    public static function bootUsesUuid()
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
