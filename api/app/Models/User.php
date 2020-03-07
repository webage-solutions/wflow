<?php

namespace App\Models;

use App\ValueObjects\Setting;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Storage;

/**
 * Class User
 * @package App\Models
 * @mixin \Eloquent
 * @property int id
 * @property string email
 * @property string name
 * @property string password
 * @property bool superuser
 * @property Collection|Organization[] organizations
 * @property Collection|UserGroup groups
 * @property Membership|UserGroupMembership membership
 * @property Setting[] settings
 * @property string name_initials
 * @property string|null avatar
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['name_initials', 'avatar'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function organizations()
    {
        return $this->belongsToMany(Organization::class)
            ->as('membership')
            ->using(Membership::class)
            ->withPivot('member_since');
    }

    public function groups()
    {
        return $this->belongsToMany(UserGroup::class)
            ->as('membership')
            ->using(UserGroupMembership::class)
            ->withPivot('member_since');
    }

    /**
     * @return Setting[]
     */
    public function getSettingsAttribute(): array
    {
        return array_map(function ($item) {
            return new Setting($item);
        }, json_decode($this->attributes['settings'], true) ?? []);
    }

    public function getAvatarAttribute(): ?string
    {
        $userId = $this->attributes['id'];
        $filename = "avatars/$userId.png";
        if (Storage::exists($filename)) {
            return route('users.avatar', $userId);
        }
        return null;
    }

    public function getNameInitialsAttribute(): string
    {
        $fullName = $this->attributes['name'];
        $names = explode(' ', $fullName);
        $firstName = array_shift($names);
        $lastName = array_pop($names);
        return $firstName[0].($lastName[0] ?? '');
    }
}
