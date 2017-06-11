<?php namespace Qooco\PppModule\Post;

use Anomaly\PagesModule\Page\Contract\PageInterface;

/**
 * Class PostRepository
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Qooco <qooco.a@gmail.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class PostRepository extends \Anomaly\PostsModule\Post\PostRepository
{

    /**
     * Finds all posts by parent page
     *
     * @param  PageInterface    $page The page
     * @return PostCollection
     */
    public function findAllByParent(PageInterface $page)
    {
        return $this->model->where('parent_id', $page->getId())->get();
    }

    /**
     * Find post by its path
     *
     * @param  string          $path The path
     * @return PostInterface
     */
    public function findByPath(string $path)
    {
        return $this->model->where('path', $path)->first();
    }
}
