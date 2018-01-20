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
        'locales' => [
            [
                'priority' =>  1,
                'locale_id' => 'en_US',
                'language' => 'en',
                'region' => 'us',
                'flag' => 'us.png',
            ],
        ],
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

    'events' => [
        'view.system/widget/edit' => function ($event, $view) use ($app) {
            $view->script('widget-language', 'bixie/languagemanager:app/bundle/widget-language.js', 'widget-edit');
            $view->data('$languageManager', [
                'languages' => $this->languages,
                'types' => $app['translatetypes']->all(),
                'default_language' => $this->default_language,
            ]);
        },
        'view.system/site/admin/edit' => function ($event, $view) use ($app) {
            $view->script('node-language', 'bixie/languagemanager:app/bundle/node-language.js', 'site-edit');
            $view->data('$languageManager', [
                'languages' => $this->languages,
                'types' => $app['translatetypes']->all(),
                'default_language' => $this->default_language,
            ]);
        },

    ],
];
