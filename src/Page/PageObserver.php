<?php namespace Qooco\PppModule\Page;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Qooco\PppModule\Page\Command\UpdatePostPaths;

/**
 * Class PageObserver
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Qooco <qooco.a@gmail.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
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

        $this->dispatch(new UpdatePostPaths($entry));
    }
}
