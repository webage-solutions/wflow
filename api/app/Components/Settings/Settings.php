<?php

namespace App\Components\Settings;

use App\Components\CustomFields\DomainTypeContract;
use App\Components\Settings\Exceptions\SettingDefaultValueNotDefined;
use App\Models\Organization;
use App\Models\ServerSettings;
use App\Models\User;
use Auth;
use Cache;
use CurrentOrganization;

class Settings
{

    const CACHE_PREFIX = 'settings';

    /**
     * @param string $key
     * @return mixed|null
     * @throws SettingDefaultValueNotDefined
     */
    public function get(string $key)
    {

        // first try the cache
        if ($value = $this->fromCache($key)) {
            return $value;
        }

        $settingConfig = config("settings.$key", null);

        // ensure that we have a settings config (required)
        if ($settingConfig === null) {
            throw new SettingDefaultValueNotDefined($key);
        }

        // Ensure that we have the setting value from default config (required)
        if (($value = ($settingConfig['value'] ?? null)) === null) {
            throw new SettingDefaultValueNotDefined($key);
        }

        // Get the allowed override level from config
        $overrideLevel = $settingConfig['override_level'] ?? null;

        // If override level is none, stop
        if ($overrideLevel === 'none') {
            return $this->toCache($key, $value);
        }

        // Check for server setting (if exists)
        $serverSettings = ServerSettings::first();
        $setting = $serverSettings->settings[$key] ?? null;

        // if override level is server or if the value is marked as final, stop
        if ($overrideLevel === 'server' || $setting->final) {
            $this->toCache($key, $value);
            return $this->toCache($key, $setting->value);
        }

        // Check for organization setting (if exists)
        $setting = CurrentOrganization::get()->settings[$key] ?? $setting;

        // if override level is organization, stop
        if ($overrideLevel === 'organization' || $setting->final) {
            return $this->toCache($key, $setting->value);
        }

        // Check for user setting (if exists)
        if ($loggedUser = Auth::user()) {
            $setting = $loggedUser->settings[$key] ?? $setting;
        }

        // finally return the value
        return $this->toCache($key, $setting->value ?? $value);
    }

    public function getDefaultSettings(): array
    {
        $output = [];
        foreach (config('settings') as $key => $item) {

            $type = $item['type'];
            $params = array_values($item['params']);
            $object = new $type(...$params);

            if ($object instanceof DomainTypeContract) {
                $output[$key]['list'] = $object->availableItems();
            }

            // server level
            $output[$key]['value'] = $item['value'];
            $output[$key]['override_level'] = $item['override_level'];

        }
        return $output;
    }

    public function getServerSettings(): array
    {
        $serverSettings = ServerSettings::first()->settings;

        $output = [];
        foreach ($this->getDefaultSettings() as $key => $item) {

            // skip non overridable settings
            if ($item['override_level'] === 'none') {
                continue;
            }

            if (isset($serverSettings[$key])) {
                $item['value'] = $serverSettings[$key]->value;
                $item['final'] = $serverSettings[$key]->final;
            }
            $output[$key] = $item;
        }
        return $output;
    }

    public function getOrganizationSettings(Organization $organization): array
    {
        $organizationSettings = $organization->settings;

        $output = [];
        foreach ($this->getServerSettings() as $key => $item) {

            // skip non overridable settings
            if ($item['override_level'] === 'server' || ($item['final'] ?? false)) {
                continue;
            }

            if (isset($item['list'])) {
                $item['list'][''] = $item['list'][$item['value']] . ' - Server Default';
                ksort($item['list']);
            }

            if (isset($organizationSettings[$key])) {
                $item['value'] = $organizationSettings[$key]->value;
                $item['final'] = $organizationSettings[$key]->final;
            } else {
                $item['value'] = '';
            }
            $output[$key] = $item;
        }
        return $output;
    }

    public function getUserSettings(User $user): array
    {
        $userSettings = $user->settings;

        $output = [];
        foreach ($this->getOrganizationSettings($user->current_organization) as $key => $item) {

            // skip non overridable settings
            if ($item['override_level'] === 'organization' || ($item['final'] ?? false)) {
                continue;
            }

            if (isset($item['list'])) {
                $item['list'][''] = $item['list'][$item['value']] . ' - Server Default';
                ksort($item['list']);
            }

            if (isset($organizationSettings[$key])) {
                $item['value'] = $userSettings[$key]->value;
                $item['final'] = $userSettings[$key]->final;
            } else {
                $item['value'] = '';
            }
            $output[$key] = $item;
        }
        return $output;
    }

    protected function getCacheKey(User $loggedUser, $key) {
        return static::CACHE_PREFIX . '_' . $loggedUser->id . '_' . $key;
    }

    protected function fromCache(string $key)
    {
        // cached settings only work for logged users
        if ($loggedUser = Auth::user()) {
            $cacheKey = $this->getCacheKey($loggedUser, $key);
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
        }
        return null;
    }

    protected function toCache(string $key, $value)
    {
        // cached settings only work for logged users
        if ($loggedUser = Auth::user()) {
            $cacheKey = $this->getCacheKey($loggedUser, $key);
            Cache::put($cacheKey, $value);
        }
        return $value;
    }
}
