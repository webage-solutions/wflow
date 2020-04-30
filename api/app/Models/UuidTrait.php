<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

trait UuidTrait
{

    public function __construct(...$params)
    {
        parent::__construct(...$params);
        $this->incrementing = false;
        $this->keyType = 'string';
    }

    public static function bootUuidTrait()
    {

        static::creating(function (Model $model) {
            $key = $model->getKeyName();
            $model->$key = Uuid::uuid4();
        });
    }
}
