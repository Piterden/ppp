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
     * @param EntryInterface $entry
     */
    public function saving(EntryInterface $entry)
    {
        parent::saving($entry);

        $entry->load('parent');

        $entry->setPath($entry->getPath());
    }
}
