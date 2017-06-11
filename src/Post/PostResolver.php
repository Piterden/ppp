<?php namespace Qooco\PppModule\Post;

/**
 * Class PostResolver
 *
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 *
 * @link          http://pyrocms.com/
 */
class PostResolver extends \Anomaly\PostsModule\Post\PostResolver
{

    /**
     * Resolves the post
     *
     * @return PostInterface
     */
    public function resolve()
    {
        if ($path = $this->route->getParameter('path'))
        {
            return $this->posts->findByPath('/' . $path);
        }

        return parent::resolve();
    }
}
