<?php namespace Qooco\PppModule\Page\Command;

use Anomaly\PagesModule\Page\Contract\PageInterface;
use Qooco\PppModule\Post\PostRepository;

/**
 * Class for update post paths.
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
        /* @var PostCollection $children */
        $children = $posts->findAllByParent($this->page);

        $children->each(
            /* @var PostInterface $post */
            function ($post)
            {
                $post->setPath($post->getPath());

                $post->save();
            }
        );
    }
}
