<?php

namespace App\Objects;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class WorkFlow
 * @package App\Objects
 * @property string when
 * @property Transition[] transitions
 */
class WorkFlow implements Arrayable, \JsonSerializable
{
    use FromJsonTrait;

    protected function fields(): array
    {
        return [
            'when',
            'transitions' => Transition::class,
        ];
    }
}
