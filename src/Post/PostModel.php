<?php namespace Qooco\PppModule\Post;

/**
 * Class PostModel
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 *
 * @link   http://pyrocms.com/
 */
class PostModel extends \Anomaly\PostsModule\Post\PostModel
{

    /**
     * Get parent
     *
     * @return mixed
     */
    public function getParent()
    {
        return $this->getRelationValue('parent');
    }
}
