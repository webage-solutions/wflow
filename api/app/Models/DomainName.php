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
 * @property string domain
 * @property int organization_id
 * @property Organization organization
 */
class DomainName extends Model
{

    //use Searchable;

    public function publicOrganization()
    {
        return $this->belongsTo(PublicOrganization::class, 'organization_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
