<?php

namespace Bixie\Languagemanager\Event;

use Pagekit\Blog\Model\Post;
use Pagekit\Event\EventSubscriberInterface;


class PostListener implements EventSubscriberInterface
{
    /**
     * @param TranslateEvent $event
     * @param Post           $post
     */
    public function translateItem (TranslateEvent $event, $post) {

        $post->title = 'trans-' . $post->title;
        $post->excerpt = 'trans-' . $post->excerpt;
        $post->content = 'trans-' . $post->content;

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