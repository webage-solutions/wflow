<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * Class Setting
 * @package App\ValueObjects
 * @property mixed value
 * @property bool final
 */
class Setting implements Arrayable, JsonSerializable
{
    use FromJsonTrait;


    /**
     * This method must return an array. When there is no key for the item, it's used directly, when there is a key,
     * the key is used and the value is used as class to instantiate other value objects.
     *
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'value',
            'final' => function($data) {
                return ((bool) $data) ?? false;
            }
        ];
    }
}
