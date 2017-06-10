<?php namespace Qooco\PppModule\Page;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Class PageObserver
 *
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 *
 * @link          http://pyrocms.com/
 */
class PageObserver extends \Anomaly\PagesModule\Page\PageObserver
{

    /**
     * Fired after saving the page.
     *
     * @param EntryInterface $entry
     */
    public function saved(EntryInterface $entry)
    {
        parent::saved($entry);

        $db = $entry->getConnection();

        $db->table('posts_posts')
            ->where('parent_id', '=', $entry->id)
            ->update([
                'path' => $db->raw('CONCAT("' . $entry->path . '/", `slug`)')
            ]);
    }
}
