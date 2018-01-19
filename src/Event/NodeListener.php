<?php

namespace Bixie\Languagemanager\Event;

use Bixie\Languagemanager\Model\Translation;
use Pagekit\Event\EventSubscriberInterface;
use Pagekit\Site\Model\Node;


class NodeListener implements EventSubscriberInterface
{
    /**
     * @param TranslateEvent $event
     * @param Node           $node
     */
    public function translateItem (TranslateEvent $event, $node) {

        if ($translation = Translation::findModelTranslation('Pagekit\Model\Node', $node->id, $event->getLanguage())) {
            $node->title = $translation->title ?: $node->title;
            ///todo check does this hurt routing?
            //$node->slug = $translation->get('slug','') ? $translation->get('slug'): $node->slug;
        }

    }

    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'translate.node' => 'translateItem',
        ];
    }

}