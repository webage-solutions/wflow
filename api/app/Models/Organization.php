<?php

namespace App\Models;

use App\ValueObjects\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Storage;

/**
 * Class Organization
 * @package App\Models
 * @mixin \Eloquent
 * @property int id
 * @property string name
 * @property int ui_client_id
 * @property array ui_settings
 * @property Setting[] settings
 * @property User[]|Collection users
 * @property Membership membership
 * @property DomainName[] domainNames
 * @property OAuthClient uiClient
 * @property string main_domain
 */
class Organization extends Model
{

    //use Searchable;

    protected $casts = [
    ];

    protected $appends = ['logo'];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->as('membership')
            ->using(Membership::class)
            ->withPivot('member_since');
    }

    public function domainNames()
    {
        return $this->hasMany(DomainName::class, 'organization_id');
    }

    public function uiClient()
    {
        return $this->belongsTo(OAuthClient::class, 'ui_client_id');
    }

    public function getMainDomainAttribute(): string
    {
        return $this->domainNames()->orderBy('main_domain', 'desc')->first()->domain;
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

    public function getLogoAttribute(): ?string
    {
        $organizationId = $this->attributes['id'];
        $filename = "logos/$organizationId.png";
        if (Storage::exists($filename)) {
            return route('organizations.logo', $organizationId);
        }
        return null;
    }
}
