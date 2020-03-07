<?php

namespace App\Models;

use App\ValueObjects\Setting;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ServerSettings
 * @mixin Eloquent
 * @package App\Models
 * @property Setting[] settings
 */
class ServerSettings extends Model
{
    protected $casts = [
    ];

    /**
     * @return Setting[]
     */
    public function getSettingsAttribute(): array
    {
        return array_map(function ($item) {
            return new Setting($item);
        }, json_decode($this->attributes['settings'], true));
    }

}
