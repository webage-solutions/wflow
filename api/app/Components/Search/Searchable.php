<?php

namespace App\Components\Search;

use App\Scopes\CurrentOrganizationScope;

trait Searchable
{

    use \Laravel\Scout\Searchable;

    public static function search($query = '', $callback = null): Builder
    {
        return app(Builder::class, [
            'model' => new static,
            'query' => $query,
            'callback' => $callback,
            'softDelete'=> static::usesSoftDelete() && config('scout.soft_delete', false),
        ]);
    }

    public static function makeAllSearchable()
    {

        $self = new static();

        $softDelete = static::usesSoftDelete() && config('scout.soft_delete', false);

        // TODO - Pass the removed scopes as parameter

        $self->withoutGlobalScopes([CurrentOrganizationScope::class])
            ->newQuery()
            ->when($softDelete, function ($query) {
                $query->withTrashed();
            })
            ->orderBy($self->getKeyName())
            ->searchable();
    }


}
