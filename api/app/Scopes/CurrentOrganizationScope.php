<?php

namespace App\Scopes;

use App\Models\User;
use Auth;
use CurrentOrganization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CurrentOrganizationScope implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $loggedUser = Auth::user();
        if ($loggedUser !== null && !$loggedUser->superuser) {
            if ($model instanceof User) {
                $builder->join('organization_user', 'organization_user.user_id', '=', 'users.id')->where('organization_user.organization_id', CurrentOrganization::get()->id);
            } else {
                $builder->where('organization_id', CurrentOrganization::get()->id);
            }
        }
    }
}
