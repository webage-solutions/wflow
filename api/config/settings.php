<?php

/**
 * This file holds the default settings of the system. All setting used on the system MUST have an entry on this file.
 * Each entry have a key, that represents the setting name, and the value is an array of fields:
 * - name - User friendly name for the field (depends on the path)
 * - path - The hierarchical path for the field.
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
    'categories' => [
        [
            'id' => 'idiom_locale',
            'name' => 'Idiom and Locale',
            'settings' => ['locale', 'timezone']
        ],
        [
            'id' => 'appearance',
            'name' => 'Appearance & Behavior',
            'children' => [
                [
                    'id' => 'colors',
                    'name' => 'UI colors',
                    'settings' => [
                        'appearance.colors.light.primary',
                        'appearance.colors.light.success',
                    ]
                ],
                [
                    'id' => 'dark',
                    'name' => 'Dark Mode',
                    'settings' => [
                        'appearance.dark',
                    ]
                ],
            ]
        ],
    ],
    'settings' => [
        'locale' => [
            'name' => 'Idiom',
            'type' => 'single_value_from_list',
            'params' => [
                'list' => [
                    'en-US' => 'English (US)',
                    'pt-BR' => 'Português do Brasil',
                ]
            ],
            'value' => 'en-US',
            'override_level' => null,
        ],
        'timezone' => [
            'name' => 'Timezone',
            'type' => 'single_value_from_list',
            'params' => [
                'list' => array_combine(timezone_identifiers_list(), timezone_identifiers_list())
            ],
            'value' => 'en-US',
            'override_level' => null,
        ],
        'appearance.colors.light.primary' => [
            'name' => 'Primary color',
            'type' => 'rgb_code',
            'params' => [],
            'value' => '1976D2',
            'override_level' => null,
        ],
        'appearance.colors.light.success' => [
            'name' => 'Success color',
            'type' => 'rgb_code',
            'params' => [],
            'value' => '1976D2',
            'override_level' => null,
        ],
        'appearance.dark' => [
            'name' => 'DarkMode',
            'type' => 'rgb_code',
            'params' => [],
            'value' => '1976D2',
            'override_level' => null,
        ]
    ]
];
