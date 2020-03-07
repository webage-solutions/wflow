<?php

namespace App\Components\CustomFields;

use App\ValueObjects\CustomFieldSchema;

class CustomFields
{

    /**
     * @param CustomFieldSchema[] $schema
     * @param array $values
     * @return array
     */
    public function parseFields(array $schema, array $values)
    {
        $fields = [];
        foreach ($schema as $key => $item) {
            if (isset($values[$key])) {
                $class = $item->type;
                /** @var AbstractType $object */
                $object = $class::buildFromSchemaParams($item->params);
                $object->loadFromDatabase($values[$key]);
                $fields[$key] = $object->valueOutput();
            }
        }
        return $fields;
    }

    /**
     * @param CustomFieldSchema[] $schema
     * @param array $values
     * @return array
     */
    public function parseScalarFields(array $schema, array $values)
    {
        $fields = [];
        foreach ($schema as $key => $item) {
            if (isset($values[$key])) {
                $class = $item->type;
                /** @var AbstractType|ObjectTypeContract $object */
                $object = $class::buildFromSchemaParams($item->params);
                $object->loadFromDatabase($values[$key]);
                $fields[$key] = $object->getKeyValue();
            }
        }
        return $fields;
    }
}
