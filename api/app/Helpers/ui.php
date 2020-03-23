<?php

if (!function_exists('uiRoute')) {
    function uiRoute(?string $domain = null): string
    {
        if (app()->runningInConsole()) {
            return env('APP_URL') .':' . (env('APP_UI_PORT') ?? '80');
        }
        $protocol = $_SERVER['REQUEST_SCHEME'] ?? 'https';
        $host = $domain ?? $_SERVER['HTTP_HOST'] ?? 'wflow.online';
        $port = env('APP_UI_PORT') ?? $_SERVER['SERVER_PORT'] ?? '80';
        return "$protocol://$host:$port";
    }
}
