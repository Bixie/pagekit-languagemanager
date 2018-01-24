<?php


namespace Bixie\Languagemanager;


use Pagekit\Application\UrlProvider;
use Pagekit\Filesystem\Filesystem;
use Pagekit\Filesystem\Locator;
use Pagekit\Routing\Generator\UrlGenerator;
use Pagekit\Routing\Router;

class LocaleUrlProvider extends UrlProvider {

    /**
     * @var LanguagemanagerModule
     */
    protected $languagemanager;

    /**
     * Constructor.
     * @param LanguagemanagerModule $languagemanager
     * @param Router                $router
     * @param Filesystem            $file
     * @param Locator               $locator
     */
    public function __construct (LanguagemanagerModule $languagemanager, Router $router, Filesystem $file, Locator $locator) {
        $this->languagemanager = $languagemanager;
        parent::__construct($router, $file, $locator);
    }

    /**
     * @param string    $path
     * @param array     $parameters
     * @param int|mixed $referenceType
     * @return false|string
     */
    public function get ($path = '', $parameters = [], $referenceType = UrlGenerator::ABSOLUTE_PATH) {
        if (0 === strpos($path, '@')) {
            return $this->getRoute($path, $parameters, $referenceType);
        }
        if (!$this->isAssetUrl($path) &&
            ($language = $this->languagemanager->getLanguage()) != $this->languagemanager->default_language) {
            $path = sprintf('/%s%s', $language, $path);
        }
        return parent::get($path, $parameters, $referenceType);
    }

    /**
     * @param string    $name
     * @param array     $parameters
     * @param int|mixed $referenceType
     * @return false|string
     */
    public function getRoute ($name, $parameters = [], $referenceType = UrlGenerator::ABSOLUTE_PATH) {
        if (!preg_match('/^@((\w*\/)api|system)/', $name)
            && ($language = $this->languagemanager->getLanguage()) != $this->languagemanager->default_language) {

            if ($query = substr(strstr($name, '?'), 1)) {
                $name = sprintf('%s/_locale?%s', strstr($name, '?', true), $query);
            } else {
                $name = sprintf('%s/_locale', $name);
            }

            $parameters['_locale'] = $language;
        }
        return parent::getRoute($name, $parameters, $referenceType);
    }

    /**
     * @param $path
     * @return false|int
     */
    protected function isAssetUrl ($path) {
        return preg_match('/(\.[\w]{2,5})$/', $path);
    }

}