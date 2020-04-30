<?php

namespace App\Objects;

use App\Components\CustomFields\TypeContract;

/**
 * Class CustomFieldSchema
 * @package App\Objects
 * @property TypeContract type
 * @property array params
 */
class CustomFieldSchema
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
            'type',
            'params',
        ];
    }
}
