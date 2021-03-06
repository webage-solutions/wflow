<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use CurrentOrganization;
use Illuminate\Http\Request;
use Settings;
use Storage;

class OrganizationsController extends Controller
{
    public function index(Request $request)
    {
        $builder = Organization::query();

        // global search
        if ($search = $request->query('q')) {
            $keys = Organization::search($search)->keys();
            $builder->whereIn('id', $keys);
        }

        // filtering
        foreach ($request->query() as $key => $value) {
            if (strpos($key, 'f_') === 0) {
                $column = substr($key, 2);
                $builder->where($column, 'like', "%$value%");
            }
        }

        // sorting
        $orderBy = $request->query('sort', null);
        if (isset($orderBy)) {
            $desc = $request->query('desc', false);
            $builder->orderBy($orderBy, $desc ? 'desc' : 'asc');
        }

        // TODO - grab pagination size from company/user settings
        // pagination
        $perPage = $request->query('perpage', 10);

        return $builder->paginate($perPage);
    }

    public function logo(int $organizationId)
    {
        $filename = "logos/$organizationId.png";
        return Storage::download($filename);
    }

    public function currentOrganizationSettings()
    {
        $currentOrganization = CurrentOrganization::get();
        return Settings::getOrganizationSettings($currentOrganization);
    }
}
