<?php namespace Qooco\PppModule;

use Anomaly\PagesModule\Page\Form\PageEntryFormSections;
use Anomaly\PagesModule\Page\Form\PageFormBuilder;
use Anomaly\PagesModule\Page\PageModel;
use Anomaly\PagesModule\Page\Tree\PageTreeBuilder;
use Anomaly\PostsModule\Page\PageObserver;
use Anomaly\PostsModule\Post\Form\PostEntryFormSections;
use Anomaly\PostsModule\Post\Form\PostFormBuilder;
use Anomaly\PostsModule\Post\PostBreadcrumb;
use Anomaly\PostsModule\Post\PostModel;
use Anomaly\PostsModule\Post\PostObserver;
use Anomaly\PostsModule\Post\PostResolver;
use Anomaly\PostsModule\Post\PostRepository;
use Anomaly\PostsModule\Post\Table\PostTableBuilder;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

/**
 * Class PppModuleServiceProvider
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Qooco <qooco.a@gmail.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class PppModuleServiceProvider extends AddonServiceProvider
{

    /**
     * Addon routes
     *
     * @var array
     */
    protected $routes = [
        // new post route
        '{path}.html' => [
            'as'    => 'anomaly.module.posts::posts.view',
            'uses'  => 'Anomaly\PostsModule\Http\Controller\PostsController@view',
            'where' => [
                'path' => '.*',
            ],
        ],
    ];

    /**
     * Addon bindings
     *
     * @var array
     */
    protected $bindings = [
        PostModel::class             => \Qooco\PppModule\Post\PostModel::class,
        PostObserver::class          => \Qooco\PppModule\Post\PostObserver::class,
        PostResolver::class          => \Qooco\PppModule\Post\PostResolver::class,
        PostBreadcrumb::class        => \Qooco\PppModule\Post\PostBreadcrumb::class,
        PostRepository::class        => \Qooco\PppModule\Post\PostRepository::class,
        PostTableBuilder::class      => \Qooco\PppModule\Post\Table\PostTableBuilder::class,
        PostFormBuilder::class       => \Qooco\PppModule\Post\Form\PostFormBuilder::class,
        PostEntryFormSections::class => \Qooco\PppModule\Post\Form\PostEntryFormSections::class,
        PageModel::class             => \Qooco\PppModule\Page\PageModel::class,
        PageObserver::class          => \Qooco\PppModule\Page\PageObserver::class,
        PageTreeBuilder::class       => \Qooco\PppModule\Page\Tree\PageTreeBuilder::class,
        PageFormBuilder::class       => \Qooco\PppModule\Page\Form\PageFormBuilder::class,
        PageEntryFormSections::class => \Qooco\PppModule\Page\Form\PageEntryFormSections::class,
    ];
}
