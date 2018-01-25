<?php

return [

    'name' => 'bixie/languagemanager',

    'type' => 'extension',

    'main' => 'Bixie\\Languagemanager\\LanguagemanagerModule',

    'autoload' => [
        'Bixie\\Languagemanager\\' => 'src'
    ],

    'routes' => [
        '/languagemanager' => [
            'name' => '@languagemanager',
            'controller' => [
                'Bixie\\Languagemanager\\Controller\\LanguagemanagerController',
                'Bixie\\Languagemanager\\Controller\\TranslationController',
            ]
        ],
        '/api/languagemanager' => [
            'name' => '@languagemanager/api',
            'controller' => [
                'Bixie\\Languagemanager\\Controller\\TranslationApiController'
            ]
        ],
    ],

    'widgets' => [
        'widgets/language-select.php',
    ],

    'resources' => [
        'bixie/languagemanager:' => ''
    ],

    'config' => [
        'default_locale' => [
            'flag' => '',
        ],
        'locales' => [],
    ],

    'menu' => [
        'languagemanager' => [
            'label' => 'Languagemanager',
            'icon' => 'packages/bixie/languagemanager/icon.svg',
            'url' => '@languagemanager/translations',
            'access' => 'languagemanager: use languagemanager',
            'active' => '@languagemanager(/*)'
        ],
        'languagemanager: translations' => [
            'label' => 'Translations',
            'parent' => 'languagemanager',
            'url' => '@languagemanager/translations',
            'access' => '',
            'active' => '@languagemanager/(translations|translation/edit)'
        ],
        'languagemanager: settings' => [
            'label' => 'Settings',
            'parent' => 'languagemanager',
            'url' => '@languagemanager/settings',
            'access' => 'system: access settings',
            'active' => '@languagemanager/settings'
        ]
    ],

    'permissions' => [
        'languagemanager: use languagemanager' => [
            'title' => 'Use languagemanager'
        ]
    ],

    'settings' => '@languagemanager/settings',

];
