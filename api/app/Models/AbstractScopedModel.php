<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractScopedModel extends Model
{
    protected static $scopes = [];

    protected static function boot()
    {
        parent::boot();

        foreach (static::$scopes as $key => $scope) {
            if (!is_numeric($key) && is_callable($scope)) {
                static::addGlobalScope($key, $scope);
                continue;
            }
            static::addGlobalScope(new $scope);
        }
    }
}