<?php namespace Qooco\PppModule\Post;

/**
 * Class PostResolver
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class PostResolver extends \Anomaly\PostsModule\Post\PostResolver
{
    public function resolve()
    {
        if($path = $this->route->getParameter('path')){
            return $this->posts->newQuery()->where('path','=','/'.$path)->first();
        }

        return parent::resolve();
    }
}
