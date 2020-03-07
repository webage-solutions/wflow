<?php

namespace App\Components\CustomFields;

/**
 * Interface ObjectTypeContract
 *
 * Represents the custom field types that returns an object as value, and need to expose a single scalar value to
 * represent the object.
 *
 * @package App\Components\CustomFields
 */
interface ObjectTypeContract
{

    /**
     * Returns the attribute name of the object that identifies it
     * @return mixed
     */
    public static function getKey();

    /**
     * Returns the value of the key attribute
     * @return mixed
     */
    public function getKeyValue();
}
