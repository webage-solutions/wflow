<?php

namespace App\Components\CustomFields;

use Illuminate\Contracts\Support\Arrayable;

class CustomFieldBag implements Arrayable
{
    /**
     * @var array
     */
    protected $fields = [];

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->fields[$name] ?? null;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->fields;
    }
}
