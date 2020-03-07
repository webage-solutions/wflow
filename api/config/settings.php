<?php

/**
 * This file holds the default settings of the system. All setting used on the system MUST have an entry on this file.
 * Each entry have a key, that represents the setting name, and the value is an array of fields:
 * - type - The custom type used to handle the setting
 * - params - An array with the parameters passed to the custom type. It's format is dependent on the custom type used.
 * - value - The default value for the setting (REQUIRED).
 * - override_level - The level where overriding is allowed. It can be:
 *   - none: no overriding is allowed, and the setting value is immutable;
 *   - server: The setting can be override on server level (using the server_settings table)
 *   - organization: The setting can be override until the organization level (using the settings field on organizations table)
 *   - null|empty: The setting can be override until the user level (using the settings field on users table)
 */

return [
    'locale' => [
        'type' => \App\Components\CustomFields\Types\SingleValueFromList::class,
        'params' => [
            'list' => [
                'en-US' => 'English (US)',
                'pt-BR' => 'Português do Brasil',
            ]
        ],
        'value' => 'en-US',
        'override_level' => null,
    ],
    'foo' => [
        'type' => \App\Components\CustomFields\Types\SingleValueFromList::class,
        'params' => [
            'list' => [
                'bar' => 'Bar',
                'baz' => 'Baz',
            ]
        ],
        'value' => 'baz',
        'override_level' => null,
    ],
];
