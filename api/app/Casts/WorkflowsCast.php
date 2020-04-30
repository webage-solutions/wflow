<?php

namespace App\Casts;

use App\Objects\WorkFlow;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class WorkflowsCast implements CastsAttributes
{

    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return array_map(function ($item) {
            return new WorkFlow($item);
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
