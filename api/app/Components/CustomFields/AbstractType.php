<?php

namespace App\Components\CustomFields;

/**
 * Interface TypeContract
 *
 * All custom field types must implement this interface
 *
 * @package App\Components\CustomFields
 */
abstract class AbstractType
{

    /**
     * @param array $params
     * @return AbstractType
     */
    abstract public static function buildFromSchemaParams(array $params): self;

    /**
     * @param $databaseValue
     * @return bool
     */
    abstract public function validate($databaseValue): bool;

    /**
     * @param $databaseValue
     * @return void
     */
    abstract public function loadFromDatabase($databaseValue): void;

    /**
     * @return mixed
     */
    abstract public function valueOutput();

}
