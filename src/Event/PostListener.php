<?php

namespace Bixie\Languagemanager\Event;

use Bixie\Languagemanager\Model\Translation;
use Pagekit\Blog\Model\Post;
use Pagekit\Event\EventSubscriberInterface;


class PostListener implements EventSubscriberInterface
{
    /**
     * @param TranslateEvent $event
     * @param Post           $post
     */
    public function translateItem (TranslateEvent $event, $post) {

        if ($translation = Translation::findModelTranslation('Pagekit\Model\Post', $post->id, $event->getLanguage())) {
            $post->title = $translation->title ?: $post->title;
            if ($translation->content) {
                $post->content = $translation->content;
            }
            if ($excerpt = $translation->get('excerpt')) {
                $post->excerpt = $excerpt;
                $post->set('excerpt', $excerpt);
            }
            if ($meta_title = $translation->get('meta.og:title')) {
                $post->set('meta.og:title', $meta_title);
            }
            if ($meta_descr = $translation->get('meta.og:description')) {
                $post->set('meta.og:description', $meta_descr);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'translate.post' => 'translateItem',
        ];
    }

}