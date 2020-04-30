<?php

namespace App\Objects;

use Exception;
use Illuminate\Contracts\Support\Arrayable;

trait FromJsonTrait
{

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * This method must return an array. When there is no key for the item, it's used directly, when there is a key,
     * the key is used and the value is used as class to instantiate other value objects.
     *
     * @return string[]
     */
    abstract public function fields(): array;

    /**
     * FromJsonTrait constructor.
     * @param array $jsonData
     * @throws Exception
     */
    public function __construct(array $jsonData)
    {

        foreach ($this->fields() as $key => $value) {

            // there is no key, just use the value as jsonData key
            if (is_int($key)) {
                $this->attributes[$value] = $jsonData[$value] ?? null;
                continue;
            }

            // there is a key, so use it as jsonData key
            $data = $jsonData[$key] ?? null;

            // if $value is a callable, execute it passing the data as parameter
            if (is_callable($value)) {
                $this->attributes[$key] = $value($data);
                continue;
            }

            // if $data is a hash/dictionary (there are keys), instantiate the object defined on $value
            if (is_array($data) && (array_keys($data) !== array_keys(array_values($data)))) {
                $this->attributes[$key] = new $value($data);
                continue;
            }

            // if $data is a vector/array(there are no keys), go through the items, instantiating the objects defined on $value
            if (is_array($data) && (array_keys($data) === array_keys(array_values($data)))) {
                foreach ($data as $item) {
                    $this->attributes[$key][] = new $value($item);
                }
                continue;
            }

            throw new Exception('Impossible to create value object of class ' . __CLASS__);

        }
    }

    /**
     * Getters
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * Setters
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function toArray()
    {
        return array_map(function ($item) {
            if ($item instanceof Arrayable) {
                return $item->toArray();
            }
            return $item;
        }, $this->attributes);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
