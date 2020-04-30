<?php

namespace App\Models;

use App\Scopes\CurrentOrganizationScope;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserGroup
 * @package App\Models
 * @mixin \Eloquent
 * @property string slug
 * @property string name
 * @property string description
 * @property int organization_id
 * @property Collection|User[] users
 * @property UserGroupMembership membership
 */
class UserGroup extends Model
{

    use ScopedTrait;

    protected static $scopes = [
        CurrentOrganizationScope::class
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->as('membership')
            ->using(UserGroupMembership::class)
            ->withPivot('member_since');
    }
}
