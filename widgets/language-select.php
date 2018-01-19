<?php

return [

    'name' => 'bixie/language-select',

    'label' => 'Language select',

    'events' => [

        'view.scripts' => function ($event, $scripts) use ($app) {
            $scripts->register('widget-language-select', 'bixie/languagemanager:app/bundle/widget-language-select.js', ['~widgets']);
        }

    ],

    'render' => function ($widget) use ($app) {
        $all_languages = $app->module('system/intl')->getAvailableLanguages();
        $languages = $app->module('bixie/languagemanager')->getActiveLanguages();
        $current_language = $app->module('bixie/languagemanager')->getLanguage();
        $template = $widget->get('view', 'dropdown');

        $flag_path = '/packages/bixie/languagemanager/assets/flags';

        return $app['view']('bixie/languagemanager/widgets/language-select-'.$template.'.php', compact(
            'widget', 'languages', 'current_language', 'all_languages', 'flag_path'
        ));
    }

];