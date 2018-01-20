<?php

namespace Bixie\Languagemanager;

use Bixie\Languagemanager\Event\ConfigureRouteListener;
use Bixie\Languagemanager\Event\LocaleListener;
use Bixie\Languagemanager\Event\NodeListener;
use Bixie\Languagemanager\Event\PageListener;
use Bixie\Languagemanager\Event\PostListener;
use Bixie\Languagemanager\Event\TranslateEvent;
use Bixie\Languagemanager\Event\WidgetListener;
use Bixie\Languagemanager\TranslationType\TranslationType;
use Bixie\Languagemanager\TranslationType\TranslationTypeCollection;
use Pagekit\Application as App;
use Pagekit\Module\Module;
use Pagekit\Site\Model\Node;
use Pagekit\Util\Arr;

/**
 * Languagemanager Main Module
 */
class LanguagemanagerModule extends Module {

    public $default_language;

    protected $current_language;

    protected $languages;

    /**
     * @param App $app
     * @return void
     */
    public function main (App $app) {
        //set locales config
        foreach ($this->config['locales'] as $locale) {
            //first language is default
            if (!isset($this->default_language)) {
                $this->default_language = $locale['language'];
            }
            $this->languages[$locale['language']] = $locale;
        }
        $this->current_language = $this->default_language;

        //init types
        $app['translationtypes'] = new TranslationTypeCollection([
            'core.page' => [
                'label' => 'Pagekit Page',
                'model' => 'Pagekit\\Model\\Page',
                'allow_manual' => false,
            ],
            'core.node' => [
                'label' => 'Pagekit Node',
                'model' => 'Pagekit\\Model\\Node',
                'edit_link' => '@site/page/edit',
                'allow_manual' => false,
            ],
            'core.widget' => [
                'label' => 'Pagekit Widget',
                'model' => 'Pagekit\\Model\\Widget',
                'edit_link' => '@site/widget/edit',
                'allow_manual' => false,
            ],
        ]);

        $app->on('boot', function () use ($app) {

            $app->subscribe(
                new LocaleListener($this),
                new ConfigureRouteListener($this, $app['routes']),
                new PageListener(),
                new PostListener(),
                new NodeListener(),
                new WidgetListener()
            );
        });

        // prio lower than 95 of this/LocaleListener (must be under 150 of system/intl),
        $app->on('request', function ($event, $request) use ($app) {
            if (!$event->isMasterRequest()) {
                return;
            }
            //overwrite UrlProvider to generate locale-specific urls
            $app->extend('url', function ($url, $app) {
                return new LocaleUrlProvider($this, $app['router'], $app['file'], $app['locator']);
            });

            if (($locale = $request->getLocale()) !== $this->default_language
                && !$app['isAdmin']
                && strpos($request->getPathInfo(), '/system/intl') === false
                && !($request->isXmlHttpRequest() && strpos($request->getPathInfo(), '/_debugbar') === false)) {

                $this->setTranslateEvents($app, $locale);
            }
        }, 90);

    }

    /**
     * Sets listeners for translatable models that are loaded
     * @param $app
     * @param $language
     */
    public function setTranslateEvents ($app, $language) {
        //translate pages and widgets as they're loaded
        foreach (['page', 'widget',] as $model) {
            $app->on("model.$model.init", function ($event, $item) use ($app, $language, $model) {

                $event = new TranslateEvent("translate.$model", $language, [
                    'default_language' => $this->default_language,
                ]);
                $app->trigger($event, [$item,]);

            }, -10);
        }
        //nodes are already inited and cached in sites/NodesListener (request, 110)
        foreach (Node::findAll(true) as $node) {
            $event = new TranslateEvent('translate.node', $language, [
                'default_language' => $this->default_language,
            ]);
            $app->trigger($event, [$node,]);
        }
        //todo blogposts

    }

    /**
     * @return array
     */
    public function getLocale () {
        $language = $this->getLanguage();
        $locale = array_filter($this->languages, function ($locale) use ($language) {
            return $locale['language'] == $language;
        });
        if (count($locale)) {
            return reset($locale);
        } else {
            return reset($this->languages);
        }
    }

    /**
     * @return string
     */
    public function getLocaleId () {
        return $this->getLocale()['locale_id'];
    }

    /**
     * @param $key
     * @return array
     */
    public function getLocaleSiteConfig ($key) {
        return Arr::get($this->getLocale()['site'], $key);
    }

    /**
     * @return string
     */
    public function getLanguage () {
        return $this->current_language;
    }

    /**
     * @param string $language
     */
    public function setLanguage ($language) {
        $this->current_language = $language;
    }

    /**
     * @return array
     */
    public function getActiveLanguages () {
        return $this->languages;
    }

    /**
     * @return string
     */
    public function getRequirementsRegex () {
        if (!isset($this->requirements_regex)) {
            $this->requirements_regex = implode('|', array_filter(
                    array_keys($this->languages),
                    function ($language) {
                        return $language != $this->default_language;
                    })
            );
        }
        return $this->requirements_regex;
    }

    /**
     * Whitelist of publicly accessable config keys
     * @return array
     */
    public function publicConfig () {
        return array_intersect_key(static::config(), array_flip([]));
    }


}

