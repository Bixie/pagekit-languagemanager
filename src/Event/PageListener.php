<?php

namespace Bixie\Languagemanager\Event;

use Bixie\Languagemanager\Model\Translation;
use Pagekit\Event\EventSubscriberInterface;
use Pagekit\Site\Model\Page;
use Pagekit\Application as App;


class PageListener implements EventSubscriberInterface
{
    /**
     * @param TranslateEvent $event
     * @param Page           $page
     */
    public function translateItem (TranslateEvent $event, $page) {

        if ($translation = Translation::findModelTranslation('Pagekit\Model\Page', $page->id, $event->getLanguage())) {
            $page->title = $translation->title ?: $page->title;
            if ($translation->content) {
                $page->content = $translation->content;
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'translate.page' => 'translateItem',
        ];
    }

}