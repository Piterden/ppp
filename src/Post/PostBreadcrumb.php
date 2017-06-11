<?php namespace Qooco\PppModule\Post;

use Anomaly\PagesModule\Page\Contract\PageInterface;
use Anomaly\PostsModule\Post\Contract\PostInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Class PostBreadcrumb
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Qooco <qooco.a@gmail.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class PostBreadcrumb extends \Anomaly\PostsModule\Post\PostBreadcrumb
{
    /**
     * Make the post breadcrumbs.
     *
     * @param PostInterface $post
     */
    public function make(PostInterface $post)
    {
        $breadcrumbs = [
            $post->getTitle() => $this->request->path(),
        ];

        $this->loadParent($post, $breadcrumbs);

        foreach (array_reverse($breadcrumbs) as $key => $url)
        {
            $this->breadcrumbs->add($key, $url);
        }
    }

    /**
     * Load the parent breadcrumbs.
     *
     * @param PageInterface $page
     * @param array         $breadcrumbs
     */
    protected function loadParent(EntryInterface $page, array &$breadcrumbs)
    {
        if ($parent = $page->getParent())
        {
            $breadcrumbs[$parent->getTitle()] = $parent->getPath();

            $this->loadParent($parent, $breadcrumbs);
        }
    }
}
