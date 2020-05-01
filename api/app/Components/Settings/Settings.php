<?php

namespace App\Components\Settings;

use App\Components\CustomFields\AbstractType;
use App\Components\CustomFields\DomainTypeContract;
use App\Components\Settings\Exceptions\InvalidCustomFieldType;
use App\Components\Settings\Exceptions\InvalidCustomFieldTypeClass;
use App\Components\Settings\Exceptions\InvalidSettingsConfig;
use App\Components\Settings\Exceptions\SettingDefaultValueNotDefined;
use App\Models\Organization;
use App\Models\ServerSettings;
use App\Models\User;
use Auth;
use Cache;
use CurrentOrganization;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

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

        $settingConfig = config("settings.settings.$key", null);

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

    /**
     * @return array
     */
    public function getDefaultSettings(): array
    {
        $output = [];
        foreach (config('settings.settings') as $key => $item) {
            $item['level'] = 'default';
            $item['final'] = false;
            $output[$key] = $item;
        }
        return $output;
    }

    public function getServerSettings(): array
    {
        $serverSettings = ServerSettings::first()->settings;

        $output = [];
        foreach ($this->getDefaultSettings() as $key => $item) {

            if ($item['override_level'] === 'none') {
                $item['final'] = true;
            } elseif (isset($serverSettings[$key])) {
                $item['value'] = $serverSettings[$key]->value;
                $item['level'] = 'server';
                $item['final'] = $item['final'] || $serverSettings[$key]->final;
            }
            $output[$key] = $item;
        }
        return $output;
    }

    public function getOrganizationSettings(?Organization $organization = null): array
    {

        if ($organization === null) {
            $organization = CurrentOrganization::get();
        }

        $organizationSettings = $organization->settings;

        $output = [];
        foreach ($this->getServerSettings() as $key => $item) {

            if ($item['final'] || $item['override_level'] === 'server') {
                $item['final'] = true;
            } elseif (
                ($item['stop_level'] ?? null) === null &&
                isset($organizationSettings[$key])
            ) {
                $item['value'] = $organizationSettings[$key]->value;
                $item['level'] = 'organization';
                $item['final'] = $organizationSettings[$key]->final;
            }
            $output[$key] = $item;
        }
        return $output;
    }

    public function getUserSettings(?User $user = null, ?Organization $organization = null): array
    {

        if ($user === null) {
            $user = Auth::user();
            $organization = CurrentOrganization::get();
        }

        $userSettings = $user->settings;

        $output = [];
        foreach ($this->getOrganizationSettings($organization) as $key => $item) {
            if ($item['final'] || $item['override_level'] === 'organization') {
                $item['final'] = true;
            } elseif (
                ($item['stop_level'] ?? null) === null &&
                isset($organizationSettings[$key])
            ) {
                $item['value'] = $userSettings[$key]->value;
                $item['level'] = 'user';
                $item['final'] = $item['final'] || $userSettings[$key]->final;
            }
            $output[$key] = $item;
        }
        return $output;
    }

    public function getEffectiveSettings(?User $user = null, ?Organization $organization = null): array
    {

        // TODO - Cache This!!!

        if (($user === null && $organization !== null) || ($user !== null && $organization === null)) {
            // TODO - Throw exception
            dd('invalid params');
        }

        if ($user === null) {
            $user = Auth::user();
            $organization = CurrentOrganization::get();
        }

        return array_map(fn ($item) => $item['value'], $this->getUserSettings($user, $organization));
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
