<?php

return [
    'title' => 'WFlow API',
    'version' => '1.0',
    'route-uri' => 'apidoc',
    'route-name' => 'apidoc',
    'route-middleware' => \Barryvdh\Cors\HandleCors::class,
    'format' => 'json',
    'included-middleware' => 'api',
    'ignore' => ['/', 'openapi', 'docs']
];