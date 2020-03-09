<?php

if (!function_exists('uiRoute')) {
    function uiRoute(): string
    {
        $protocol = env('APP_UI_PROTOCOL', $_SERVER['REQUEST_SCHEME']) ?? 'https';
        $host = env('APP_UI_HOST', $_SERVER['HTTP_HOST']);
        $port = env('APP_UI_PORT', $_SERVER['SERVER_PORT']);
        return "$protocol://$host:$port";
    }
}
