<?php

namespace Bixie\Languagemanager\Event;

use Bixie\Languagemanager\LanguagemanagerModule;
use Pagekit\Event\EventSubscriberInterface;
use Pagekit\Application as App;
use Pagekit\View\Helper\MetaHelper;
use Pagekit\View\View;

class LocaleListener implements EventSubscriberInterface {

    /**
     * @var LanguagemanagerModule
     */
    protected $languagemanager;

    /**
     * Constructor.
     * @param LanguagemanagerModule $languagemanager
     */
    public function __construct (LanguagemanagerModule $languagemanager) {
        $this->languagemanager = $languagemanager;
    }

    public function onRequest ($event, $request) {
        if (App::isAdmin() || !$event->isMasterRequest()
            || strpos($request->getPathInfo(), '/system/intl') === 0
            || ($request->isXmlHttpRequest() && !$request->attributes->get('_translate'))
            //UIkit uploader does not send the { 'X-Requested-With': 'XMLHttpRequest' } header by default
            || ($request->get('files') || $request->get('file'))) {
            return;
        }

        // try to see if the locale has been set as a _locale request parameter
        if (!$language = $request->get('_locale')
            or !preg_match('/^('.$this->languagemanager->getRequirementsRegex().')$/', $language)) {
            // if no explicit locale has been set on this request, use the session value or the default
            $language = App::session()->get('_locale', $this->languagemanager->default_language);
        }

        //set language in request/modules
        $request->setLocale($language);
        $this->languagemanager->setLanguage($language, $request->get('_locale_persist', true));
        App::module('system/intl')->setLocale($this->languagemanager->getLocaleId());
    }

    /**
     * Set admin language per user.
     * XHR requests from admin are not localized by default in Pagekit, they get the site language
     * This is called in a separate listener because the User Provider is nog available in the main listener.
     * @param $event
     * @param $request
     */
    public function adminLanguage ($event, $request) {
        //set locale for admin if set in user object
        if (App::isAdmin() && $event->isMasterRequest()) {
            $admin_locale_id = App::config('system')->get('admin.locale');
            if ($user_locale_id = App::user()->get('admin_locale_id', '') and $user_locale_id != $admin_locale_id) {
                App::module('system/intl')->setLocale($user_locale_id);
            }
            return;
        }
    }

    /**
     * @param $event
     * @param View $view
     */
    public function onViewInit ($event, $view) {
        if (App::isAdmin()) {
            return;
        }
        if ($title = $this->languagemanager->getLocaleSiteConfig('title')) {
            $view->params->set('title', $title);
        }
    }

    /**
     * @param $event
     * @param MetaHelper $meta
     */
    public function onMeta ($event, $meta) {
        if (App::isAdmin()) {
            return;
        }
        if ($title = $this->languagemanager->getLocaleSiteConfig('title')) {
            //can't change App::config('system/site'), so manipulate string afterwards
            $meta->add('title', str_replace(
                ' | ' . App::config('system/site')->get('title'),
                ' | ' . $title,
                $meta->get('title'))
            );

            $meta->add('og:site_name', $title);
        }

        $meta->add('og:image', $this->languagemanager->getLocaleSiteConfig('meta.image'));
        $meta->add('og:description', $this->languagemanager->getLocaleSiteConfig('meta.description'));
        $meta->add('description', $this->languagemanager->getLocaleSiteConfig('meta.description'));
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe () {
        return [
            //site intl event (system/index.php) has prio 150
            //lower than 100 where request params are added
            'request' => [
                ['onRequest', 95],
                //lower than 50 where userprovider is set
                ['adminLanguage', 45],
            ],
            //system title is set at 10
            'view.init' => ['onViewInit', -40],
            //theme meta is set at -30, system title is set at -50
            'view.meta' => ['onMeta', -60],
        ];
    }

}
