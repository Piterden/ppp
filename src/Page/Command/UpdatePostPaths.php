<?php namespace Qooco\PppModule\Page\Command;

use Anomaly\PagesModule\Page\Contract\PageInterface;
use Qooco\PppModule\Post\PostRepository;

/**
 * Class UpdatePostPaths
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Qooco <qooco.a@gmail.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class UpdatePostPaths
{

    /**
     * Page entry
     *
     * @var PageInterface
     */
    protected $page;

    /**
     * Create an instance of UpdatePostPaths class
     *
     * @param PageInterface $page The page
     */
    public function __construct(PageInterface $page)
    {
        $this->page = $page;
    }

    /**
     * Handle the command
     *
     * @param PostRepository $posts The posts
     */
    public function handle(PostRepository $posts)
    {
        $posts->findAllByParent($this->page)->each(
            /* @var PostInterface $post */
            function ($post)
            {
                $post->save();
            }
        );
    }
}
