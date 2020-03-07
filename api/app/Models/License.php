<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class License
 * @package App\Models
 * @since 1.0
 * @mixin \Eloquent
 * @property int $id
 * @property bool $allow_multi_tenancy
 * @property string $server_ip
 * @property Carbon $valid_since
 * @property Carbon $valid_until
 * @property string $signature
 * @property string $file
 * @property bool $active
 * @property Carbon $added_at
 */
class License extends Model
{

    use RevisionableTrait;

    const CREATED_AT = 'added_at';

    protected $dates = ['valid_since', 'valid_until'];
}