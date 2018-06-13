<?php

namespace Bixie\Languagemanager\Controller;

use Pagekit\Application as App;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Languagemanager Controller
 */
class LanguagemanagerController {

    /**
     * @Request({"language": "string"})
     * @param $language
     * @return RedirectResponse
     */
    public function setLanguageAction ($language) {
        $languagemanager = App::module('bixie/languagemanager');
        $languagemanager->setLanguage($language);
        //trim host and language prefix from referrer url
        $langs_regex = $languagemanager->getRequirementsRegex();
        $redirect = preg_replace('#(https?:)?//[^/]+(/('.$langs_regex.')(/|$))?#', '', App::url()->previous());
        //add lang to url if not default
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
        $user = App::user();

        return [
            '$view' => [
                'title' => 'Languagemanager settings',
                'name' => 'bixie/languagemanager/admin/settings.php'
            ],
            '$data' => [
                'flags' => $flags,
                'admin_language' => [
                    'user' => $user,
                    'admin_locale_id' => $user->get('admin_locale_id', ''),
                ],
                'site_locale_id' => App::config('system')->get('site.locale'),
                'languages' => App::module('system/intl')->getAvailableLanguages(),
                'config' => App::module('bixie/languagemanager')->config()
            ]
        ];
    }

    /**
     * @Access ("system: access settings", admin=true)
     * @Route("/config", methods="POST")
     * @Request ({"config": "array", "admin_language": "array"}, csrf=true)
     * @param array $config
     * @param array $admin_language
     * @return array
     */
    public function configAction ($config = [], $admin_language = []) {
        App::config('bixie/languagemanager')->merge($config, true)->set('locales', $config['locales']);
        $user = App::user();
        if (isset($admin_language['user'], $admin_language['user']['id'], $admin_language['admin_locale_id']) and
            $admin_language['user']['id'] == $user->id and $user->get('admin_locale_id', '') != $admin_language['admin_locale_id']) {
            $user->set('admin_locale_id', $admin_language['admin_locale_id']);
            $user->save();
        }
        //flush cache to generate new routes
        App::cache()->flushAll();
        return ['message' => 'success'];
    }


}

