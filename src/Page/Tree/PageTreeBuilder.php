<?php namespace Qooco\PppModule\Page\Tree;

use Qooco\PppModule\Page\Tree\Command\BuildDropdown;

/**
 * Class PageTreeBuilder
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Qooco <qooco.a@gmail.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class PageTreeBuilder extends \Anomaly\PagesModule\Page\Tree\PageTreeBuilder
{

    /**
     * @return mixed
     */
    public function onReady()
    {
        $dropdown = $this->dispatch(new BuildDropdown());

        $this->setButtons([
            'add'        => [
                'data-toggle' => 'modal',
                'data-target' => '#modal',
                'text'        => 'anomaly.module.pages::button.create_child_page',
                'href'        => 'admin/pages/ajax/choose_type?parent={entry.id}',
            ],
            'show_posts' => [
                'text' => function ($page)
                {
                    if ($count = $page->getPosts()->count())
                    {
                        return "Show Posts ({$count})";
                    }

                    return '';
                },
                'href' => 'admin/posts?view=all&filter_parent={entry.id}',
                'icon' => 'list-ol',
                'type' => 'success',
            ],
            'add_post'   => [
                'text'     => 'Add Post',
                'icon'     => 'fa fa-plus',
                'type'     => 'success',
                'href'     => '/admin/posts/create?type={entry.default_post_type}&parent={entry.id}',
                'dropdown' => count($dropdown) > 1 ? $dropdown : [],
            ],
            'view'       => [
                'target' => '_blank',
            ],
            'delete',
        ]);
    }
}
