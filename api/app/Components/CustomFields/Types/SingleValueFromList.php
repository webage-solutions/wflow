<?php

namespace App\Components\CustomFields\Types;

use App\Components\CustomFields\AbstractType;
use App\Components\CustomFields\DomainTypeContract;

class SingleValueFromList extends AbstractType implements DomainTypeContract
{

    protected $availableItems = [];

    public function __construct(array $list)
    {
        $this->availableItems = $list;
    }

    public function availableItems(): array
    {
        return $this->availableItems;
    }

    /**
     * @param array $params
     * @return AbstractType
     */
    public static function buildFromSchemaParams(array $params): AbstractType
    {
        // TODO: Implement buildFromSchemaParams() method.
    }

    /**
     * @param $databaseValue
     * @return bool
     */
    public function validate($databaseValue): bool
    {
        // TODO: Implement validate() method.
    }

    /**
     * @param $databaseValue
     * @return void
     */
    public function loadFromDatabase($databaseValue): void
    {
        // TODO: Implement loadFromDatabase() method.
    }

    /**
     * @return mixed
     */
    public function valueOutput()
    {
        // TODO: Implement valueOutput() method.
    }
}
