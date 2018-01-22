<?php

namespace Bixie\Languagemanager\Controller;

use Pagekit\Application as App;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Languagemanager Admin Controller
 */
class LanguagemanagerController {

    /**
     * @Request({"language": "string"})
     * @param $language
     * @return RedirectResponse
     */
    public function setLanguageAction ($language) {
        $languagemanager = App::module('bixie/languagemanager');
        $langs_regex = $languagemanager->getRequirementsRegex();
        //trim host and language prefix from referrer url
        $redirect = preg_replace('#(https?:)?//[^/]+(/('.$langs_regex.')(/|$))?#', '', App::url()->previous());
        //add lang if not default
        if ($language != $languagemanager->default_language) {
            $redirect = '/' . $language . '/' . ltrim($redirect, '/');
        }

        return App::redirect($redirect);
    }

    /**
     * @Access ("system: access settings", admin=true)
     * @return array
     */
    public function settingsAction () {

        $flag_path = '/packages/bixie/languagemanager/assets/flags';

        $flags = array_map('basename', glob(App::locator()->get($flag_path) . '/*.png'));

        return [
            '$view' => [
                'title' => 'Languagemanager settings',
                'name' => 'bixie/languagemanager/admin/settings.php'
            ],
            '$data' => [
                'flags' => $flags,
                'site_locale_id' => App::config('system')->get('site.locale'),
                'languages' => App::module('system/intl')->getAvailableLanguages(),
                'config' => App::module('bixie/languagemanager')->config()
            ]
        ];
    }

    /**
     * @Access ("system: access settings", admin=true)
     * @Request ({"config": "array"}, csrf=true)
     * @param array $config
     * @return array
     */
    public function configAction ($config = []) {
        App::config('bixie/languagemanager')->merge($config, true)->set('locales', $config['locales']);

        //flush cache to generate new routes
        App::cache()->flushAll();
        return ['message' => 'success'];
    }


}

