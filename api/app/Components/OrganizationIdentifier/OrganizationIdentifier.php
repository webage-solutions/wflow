<?php

namespace App\Components\OrganizationIdentifier;

use App\Models\Organization;

class OrganizationIdentifier
{

    /**
     * @var Organization
     */
    protected $organization;

    public function set(Organization $organization)
    {
        $this->organization = $organization;
    }

    public function get(): ?Organization
    {
        return $this->organization ?? null;
    }
}
