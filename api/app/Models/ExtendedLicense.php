<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class UsersLicense
 * @package App\Models
 * @since 1.0
 * @property int $id
 * @property int $tenants
 * @property int $internal_users
 * @property int $internal_users_per_tenant
 * @property int $external_users
 * @property int $external_users_per_tenant
 * @property Carbon $valid_since
 * @property Carbon $valid_until
 * @property string $signature
 * @property string $file
 * @property bool $active
 * @property Carbon $added_at
 */
class ExtendedLicense extends Model
{
    use RevisionableTrait;

    const CREATED_AT = 'added_at';

    protected $dates = ['valid_since', 'valid_until'];
}