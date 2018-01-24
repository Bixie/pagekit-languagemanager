<?php

namespace Bixie\Languagemanager\Event;

use Bixie\Languagemanager\LanguagemanagerModule;
use Pagekit\Event\Event;
use Pagekit\Event\EventSubscriberInterface;
use Pagekit\Routing\Route;
use Pagekit\Routing\Routes;
use Symfony\Component\Routing\RouteCollection;

class ConfigureRouteListener implements EventSubscriberInterface {

    /**
     * @var LanguagemanagerModule
     */
    protected $languagemanager;
    /**
     * @var Routes
     */
    protected $routes;
    /**
     * @var string
     */
    protected $requirements_regex;

    /**
     * Constructor.
     * @param LanguagemanagerModule $languagemanager
     * @param Routes                $routes
     */
    public function __construct (LanguagemanagerModule $languagemanager, Routes $routes) {
        $this->languagemanager = $languagemanager;
        $this->routes = $routes;
    }


    /**
     * adds locale url for this route
     * @param Event           $event
     * @param Route           $route
     * @param RouteCollection $routes
     */
    public function onConfigureRoute ($event, $route, $routes) {
        if (count($this->languagemanager->getActiveLanguages()) === 1) {
            //no extra languages defined
            return;
        }
        if (preg_match('/^\/(admin|api|system)/', $route->getPath()) && !$route->getDefault('_translate')) {
            return;
        }
        $name = $route->getName();

        $variables = $route->compile()->getPathVariables();

        // pass query params
        $params = [];
        if ($query = substr(strstr($route->getName(), '?'), 1)) {
            parse_str($query, $params);
        }

        $_routes = [$route];
        //aliases(/frontpage)
        $aliases = array_filter($this->routes->getAliases(), function ($alias) use ($name) {
            return $name == $alias->getName() || $name == strtok($alias->getName(), '?');
        });

        if ($aliases) {
            $_routes = array_merge($_routes, array_map(function ($alias) use ($route, $params) {
                $alias->setDefaults(array_merge($route->getDefaults(), $params, $alias->getDefaults()));
                return $alias;
            }, $aliases));
        }

        foreach ($_routes as $route) {

            if ($query = substr(strstr($route->getName(), '?'), 1)) {
                // add query params
                parse_str($query, $params);
                $name = sprintf('%s/_locale?%s', strstr($route->getName(), '?', true), $query);
            } else {
                $name = sprintf('%s/_locale', $route->getName());
            }
            $path = rtrim(sprintf('/{_locale}%s', $route->getPath()), '/');

            $routes->add(
                $name,
                new Route(
                    $path,
                    array_merge(
                        $route->getDefaults(),
                        $params,
                        ['_variables' => $variables]
                    ),
                    ['_locale' => $this->languagemanager->getRequirementsRegex(),]
                ));

        }

    }

    /**
     * {@inheritdoc}
     */
    public function subscribe () {
        return [
            'route.configure' => ['onConfigureRoute', -10]
        ];
    }

}
