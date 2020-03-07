<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class Membership
 * @package App\Models
 * @property Carbon member_since
 */
class Membership extends Pivot
{
    const CREATED_AT = 'member_since';
    const UPDATED_AT = null;

    protected $dates = [
        'member_since'
    ];
}