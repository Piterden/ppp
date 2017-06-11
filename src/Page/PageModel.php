<?php namespace Qooco\PppModule\Page;

use Anomaly\PostsModule\Post\PostCollection;
use Anomaly\PostsModule\Post\PostModel;

class PageModel extends \Anomaly\PagesModule\Page\PageModel
{

    /**
     * Children posts
     *
     * @return HasMany
     */
    public function posts()
    {
        return $this->hasMany(
            PostModel::class,
            'parent_id',
            'id'
        )->orderBy('sort_order', 'ASC');
    }

    /**
     * Gets the posts.
     *
     * @return PostCollection The posts.
     */
    public function getPosts()
    {
        return $this->posts()->get();
    }

    /**
     * Sets the posts.
     *
     * @param  PostCollection $posts The posts
     * @return $this
     */
    public function setPosts(PostCollection $posts)
    {
        $this->posts = $posts;

        return $this;
    }

    /**
     * Gets the default page layout.
     *
     * @return string The default page layout.
     */
    public function getDefaultPageLayout()
    {
        return $this->default_page_layout;
    }

    /**
     * Gets the default post type.
     *
     * @return integer The default post type.
     */
    public function getDefaultPostType()
    {
        return $this->default_post_type;
    }
}
