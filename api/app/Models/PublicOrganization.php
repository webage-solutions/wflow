<?php

namespace App\Models;

use App\Objects\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Storage;

/**
 * Class PublicOrganization
 * @package App\Models
 */
class PublicOrganization extends Organization
{
    /**
     * @var string
     */
    protected $table = 'organizations';


    protected $visible = ['id', 'domain', 'name', 'logo', 'uiClient', 'main_domain'];
}
