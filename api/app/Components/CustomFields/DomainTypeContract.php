<?php

namespace App\Components\CustomFields;

/**
 * Interface DomainTypeContract
 *
 * Represents types of custom fields where the field value is choose from a list of valid values
 *
 * @package App\Components\CustomFields
 */
interface DomainTypeContract
{
    public function availableItems(): array;
}
