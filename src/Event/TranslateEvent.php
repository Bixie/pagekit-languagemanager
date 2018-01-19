<?php

namespace Bixie\Languagemanager\Event;

use Pagekit\Event\Event;

class TranslateEvent extends Event {

    /**
     * @var string
     */
    protected $language;

    /**
     * Constructor.
     * @param string $name
     * @param string $language
     * @param array  $parameters
     */
    public function __construct ($name, $language, array $parameters = []) {
        parent::__construct($name, $parameters);

        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getLanguage () {
        return $this->language;
    }

}
