<?php namespace Qooco\PppModule\Page\Tree;

use Anomaly\PagesModule\Type\Contract\TypeRepositoryInterface;

class PageTreeBuilder extends \Anomaly\PagesModule\Page\Tree\PageTreeBuilder
{

    /**
     * @return mixed
     */
    public function onReady()
    {
        /**
         * @var Collection $post_types
         */
        $post_types = app(TypeRepositoryInterface::class)->all();

        $dropdown = $post_types->map(function ($type)
        {
            return [
                'text'       => 'Add ' . $type->name . ($type->id == 1 ? ' Post' : ''),
                'attributes' => [
                    'href' => '/admin/posts/create?type=' . $type->id . '&parent={entry.id}',
                ],
            ];
        })->all();

        $this->setButtons(
            [
                'add'        => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'text'        => 'anomaly.module.pages::button.create_child_page',
                    'href'        => 'admin/pages/ajax/choose_type?parent={entry.id}',
                ],
                'show_posts' => [
                    'text' => function ($entry)
                    {
                        $count = $entry->posts()->count();

                        return $count ? 'Show Posts (' . $count . ')' : '';
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
            ]
        );
    }
}
