<?php

namespace Bixie\Languagemanager\Event;

use Bixie\Languagemanager\Model\Translation;
use Pagekit\Event\EventSubscriberInterface;
use Pagekit\Widget\Model\Widget;
use Pagekit\Application as App;


class WidgetListener implements EventSubscriberInterface
{
    /**
     * @param TranslateEvent $event
     * @param Widget         $widget
     */
    public function translateItem (TranslateEvent $event, $widget) {

        if (!$type = App::widget($widget->type)) {
            return;
        }

        if ($translation = Translation::findModelTranslation('Pagekit\Model\Widget', $widget->id, $event->getLanguage())) {
            if (is_callable($type->get('translate'))) {
                call_user_func($type->get('translate'), $widget, $translation, $event->getLanguage());
            } else {
                $widget->title = $translation->title ?: $widget->title;
                if ($translation->content) {
                    $widget->set('content', $translation->content);
                }
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function subscribe() {
        return [
            'translate.widget' => 'translateItem',
        ];
    }

}