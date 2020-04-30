<?php

namespace App\Casts;

use App\Objects\CustomFieldSchema;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class CustomFieldsSchemaCast implements CastsAttributes
{

    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return array_map(function ($item) {
            return new CustomFieldSchema($item);
        }, json_decode($attributes[$key], true));
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        // TODO: Implement set() method.
    }
}
