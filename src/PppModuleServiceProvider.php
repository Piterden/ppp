<?php namespace Qooco\PppModule;

use Anomaly\CheckboxesFieldType\Handler\Countries;
use Anomaly\PagesModule\Page\Contract\PageRepositoryInterface;
use Anomaly\PagesModule\Page\Form\PageEntryFormBuilder;
use Anomaly\PagesModule\Page\Form\PageEntryFormSections;
use Anomaly\PagesModule\Page\Form\PageFormBuilder;
use Anomaly\PagesModule\Page\PageModel;
use Anomaly\PagesModule\Page\Tree\PageTreeBuilder;
use Anomaly\PostsModule\Post\Form\PostEntryFormBuilder;
use Anomaly\PostsModule\Post\Form\PostEntryFormSections;
use Anomaly\PostsModule\Post\Form\PostFormBuilder;
use Anomaly\PostsModule\Post\PostBreadcrumb;
use Anomaly\PostsModule\Post\PostCriteria;
use Anomaly\PostsModule\Post\PostModel;
use Anomaly\PostsModule\Post\PostResolver;
use Anomaly\PostsModule\Post\Table\PostTableBuilder;
use Anomaly\PostsModule\Type\Contract\TypeRepositoryInterface;
use Anomaly\RelationshipFieldType\RelationshipFieldType;
use Anomaly\SelectFieldType\SelectFieldType;
use Anomaly\SlugFieldType\SlugFieldType;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Entry\EntryCriteria;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Support\Collection;
use Qooco\PppModule\Page\PageCriteria;

class PppModuleServiceProvider extends AddonServiceProvider
{

    protected $plugins = [];

    protected $commands = [];

    protected $routes = [
        // new post route
        "{path}.html" => [
            'as'   => 'anomaly.module.posts::posts.view',
            'uses' => 'Anomaly\PostsModule\Http\Controller\PostsController@view',
            'where'=> [
                'path' => '.*'
            ]
        ],
    ];


    protected $middleware = [];

    protected $listeners = [];

    protected $aliases = [];

    protected $bindings = [
        PostResolver::class => \Qooco\PppModule\Post\PostResolver::class,
        PostBreadcrumb::class => \Qooco\PppModule\Post\PostBreadcrumb::class,
    ];

    protected $providers = [];

    protected $singletons = [];

    protected $overrides = [];

    protected $mobile = [];

    public function register(
        PostModel $post_model,
        PostTableBuilder $post_table_builder,
        PostFormBuilder $post_form_builder,
        PostEntryFormBuilder $post_entry_form_builder,
        PageModel $page_model,
        PageTreeBuilder $page_tree_builder,
        PageFormBuilder $page_form_builder,
        PageEntryFormBuilder $page_entry_form_builder
    ) {

        # 1) POSTS ======================================
        $post_model->bind('get_parent', function() {
            /** @var PostModel $this */
            return $this->getRelationValue('parent');
        });

        PostModel::saved(function(EntryModel $entry)
        {
            $entry->load('parent');
            $path = $entry->parent ? ($entry->parent->getPath() . '/' . $entry->slug) : 'posts/' . $entry->slug;

            $entry->getConnection()
                ->table('posts_posts')
                ->where('id','=',$entry->id)
                ->update(compact('path'));
        }, 2);

        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ POST TABLE ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $post_table_builder->listen('ready', function(PostTableBuilder $builder)
        {
            $parent_id = request('filter_parent');
            $filters = $builder->getFilters();
            $columns = $builder->getColumns();

            if($idx = array_search('category',$filters)) {
                unset($filters[$idx]);
                $filters['parent'] = [
                    'filter' => 'select',
                    'options' => function(SelectFieldType $fieldType, PageRepositoryInterface $repository){

                        $fieldType->setOptions(
                            $repository->newQuery()->whereHas('posts')->get()->pluck('path','id')->sort()->all()
                        );
                    }
                ];
            }
            if($idx = array_search('category',$columns)) {
                if($parent_id){ unset($columns[$idx]); }else{ $columns[$idx] = 'path'; }
                //$columns[$idx] = 'path';
            }

            $builder->setFilters($filters);
            $builder->setColumns($columns);
            if( $parent_id ){
                $page = app(PageRepositoryInterface::class)->find($parent_id);
                //$builder->setOption('title', $page->title.' '.$page->path);
                $title[] = $page->getTitle();
                $parent = $page->getParent();
                while($parent){
                    $title[] = $parent->getTitle();
                    $parent = $parent->getParent();
                }
                $builder->setOption('title', join(' / ',array_reverse($title)));
            }
        });

        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ POST FORM ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $post_form_builder->listen('built', function(PostFormBuilder $builder)
        {
            if( $page_id = request('parent')){
                $builder->getForm()->getField('parent')->setValue($page_id);
                $parent = app(PageRepositoryInterface::class)->find($page_id);
                if(!$parent){
                    abort(404,'Can\'t create post for non existing page!');
                }
            }else{
                $parent = $builder->getFormEntry()->parent;
            }

            $path = ($parent ? url(trim('/'.$parent->path,'/')) : url('/')) . '/';

            /** @var SlugFieldType */
            $builder->getForm()->getField('slug')->configSet('prefix', $path);

            /** @var RelationshipFieldType */
            $builder->getForm()->getField('parent')->configSet('mode', 'lookup');
        });

        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ POST ENTRY FORM (MULTIFORM) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $post_entry_form_builder->listen('ready', function(PostEntryFormBuilder $builder)
        {
            (new PostEntryFormSections())->handle($builder);
            $sections = $builder->getSections();
            array_unshift($sections['post']['tabs']['organization']['fields'], 'post_parent');
            $builder->setSections($sections);
        });


        # 2) PAGES =======================================

        $page_model->bind('posts', function(){
            return $this->hasMany('Anomaly\PostsModule\Post\PostModel', 'parent_id', 'id')
                ->orderBy('sort_order', 'ASC');
        });

        $page_model->bind('get_posts', function() {
            return $this->posts()->get();
        });

        PageModel::saved(function(EntryModel $entry) {
            $db = $entry->getConnection();

            $db->table('posts_posts')
                ->where('parent_id','=',$entry->id)
                ->update([ 'path' => $db->raw('CONCAT("'.$entry->path.'/", `slug`)') ]);
        }, 2);

        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE FORM ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $page_form_builder->listen('built', function(PageFormBuilder $builder){
            if( $page_id = request('parent')){

                $parent = app(PageRepositoryInterface::class)->find($page_id);
                if(!$parent){
                    abort(404,'Can\'t create post for non existing page!');
                }

                $builder->getForm()->getField('theme_layout')->setValue($parent->default_page_layout);
                $builder->getForm()->getField('default_page_layout')->setValue($parent->default_page_layout);
                $builder->getForm()->getField('default_post_type')->setValue($parent->default_post_type);
            }
        });

        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE ENTRY FORM ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $page_entry_form_builder->listen('ready', function(PageEntryFormBuilder $builder){
            (new PageEntryFormSections())->handle($builder);
            $sections = $builder->getSections();
            $sections['page']['tabs']['options']['fields'][] = 'page_default_page_layout';
            $sections['page']['tabs']['options']['fields'][] = 'page_default_post_type';
            $builder->setSections($sections);
        });

        # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE TREE ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $page_tree_builder->listen('ready', function(PageTreeBuilder $builder)
        {
            /** @var Collection $post_types */
            $post_types = app(TypeRepositoryInterface::class)->all();

            $dropdown = $post_types->map(function($type){
                return [
                    'text' => 'Add ' . $type->name . ($type->id == 1 ? ' Post' : ''),
                    'attributes' => [
                        'href' => '/admin/posts/create?type=' . $type->id . '&parent={entry.id}',
                    ]
                ];
            })->all();

            $builder->setButtons(
                [
                    'add'  => [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal',
                        'text'        => 'anomaly.module.pages::button.create_child_page',
                        'href'        => 'admin/pages/ajax/choose_type?parent={entry.id}',
                    ],
                    'show_posts' => [
                        'text' => function($entry){
                            $count = $entry->posts()->count();
                            return $count ? 'Show Posts ('.$count.')' : '';
                        },
                        'href' => 'admin/posts?view=all&filter_parent={entry.id}',
                        'icon' => 'list-ol',
                        'type' => 'success'
                    ],
                    'add_post' =>  [
                        'text' => 'Add Post',
                        'icon' => 'fa fa-plus',
                        'type' => 'success',
                        'href' => '/admin/posts/create?type={entry.default_post_type}&parent={entry.id}',
                        'dropdown' => count($dropdown) > 1 ? $dropdown : []
                    ],
                    'view' => [
                        'target' => '_blank',
                    ],
                    'delete',
                ]
            );
        });

    }

    public function map()
    {
    }

}
