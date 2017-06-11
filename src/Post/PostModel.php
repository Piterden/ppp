<?php namespace Qooco\PppModule\Post;

/**
 * Class PostModel
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Qooco <qooco.a@gmail.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class PostModel extends \Anomaly\PostsModule\Post\PostModel
{

    /**
     * Gets the path.
     *
     * @return string The path.
     */
    public function getPath()
    {
        return ($this->parent)
        ? ($this->parent->getPath() . '/' . $this->slug)
        : 'posts/' . $this->slug;
    }

    /**
     * Sets the path.
     *
     * @param  string  $path The path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get parent
     *
     * @return mixed
     */
    public function getParent()
    {
        return $this->getRelationValue('parent');
    }

    /**
     * Sets the parent.
     *
     * @param  PageInterface $page The page
     * @return $this
     */
    public function setParent(PageInterface $page)
    {
        $this->parent = $page;

        return $this;
    }
}
