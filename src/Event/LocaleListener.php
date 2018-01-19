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
            || ($request->isXmlHttpRequest() && strpos($request->getPathInfo(), '/_debugbar') === false)) {
            return;
        }

        // try to see if the locale has been set as a _locale routing parameter
        if (!$language = $request->attributes->get('_locale')) {
            // if no explicit locale has been set on this request, use the default
            $language = $this->languagemanager->default_language;
        }
        //set language in modules
        $this->languagemanager->setLanguage($language);
        $request->setLocale($language);

        App::module('system/intl')->setLocale($this->languagemanager->getLocaleId());
    }

    /**
     * @param $event
     * @param View $view
     */
    public function onViewInit ($event, $view) {

        $view->params->set('title', $this->languagemanager->getLocaleSiteConfig('title'));

    }

    /**
     * @param $event
     * @param MetaHelper $meta
     */
    public function onMeta ($event, $meta) {
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

//        App::module('system/site')->config = array_merge(
//            App::module('system/site')->config,
//            $this->languagemanager->getLocaleSiteConfig()
//        );
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe () {
        return [
            //site intl event (system/index.php) has prio 150
            //lower than 100 where request params are added
            'request' => ['onRequest', 95],
            //system title is set at 10
            'view.init' => ['onViewInit', -40],
            //theme meta is set at -30, system title is set at -50
            'view.meta' => ['onMeta', -60],
        ];
    }

}
