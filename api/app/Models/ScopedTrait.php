<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

trait ScopedTrait
{

    public static function bootScopedTrait()
    {
        foreach (static::$scopes as $key => $scope) {
            if (!is_numeric($key) && is_callable($scope)) {
                static::addGlobalScope($key, $scope);
                continue;
            }
            static::addGlobalScope(new $scope);
        }
    }
}
