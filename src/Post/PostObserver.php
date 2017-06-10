<?php namespace Qooco\PppModule\Post;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Class PostObserver
 *
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 *
 * @link          http://pyrocms.com/
 */
class PostObserver extends \Anomaly\PostsModule\Post\PostObserver
{

    /**
     * Fired just after the entry was saved.
     *
     * @param EntryInterface|PostInterface $entry
     */
    public function saved(EntryInterface $entry)
    {
        $entry->load('parent');

        $path = $entry->parent
        ? ($entry->parent->getPath() . '/' . $entry->slug)
        : 'posts/' . $entry->slug;

        $entry->getConnection()
            ->table('posts_posts')
            ->where('id', $entry->id)
            ->update(compact('path'));
    }
}
