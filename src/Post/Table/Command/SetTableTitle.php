<?php namespace Qooco\PppModule\Post\Table\Command;

use Anomaly\PagesModule\Page\Contract\PageRepositoryInterface;
use Qooco\PppModule\Post\Table\PostTableBuilder;

/**
 * Class SetTableTitle
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Qooco <qooco.a@gmail.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class SetTableTitle
{

    /**
     * Post table builder
     *
     * @var PostTableBuilder
     */
    protected $builder;

    /**
     * Create new instance of SetTableTitle class
     *
     * @param PostTableBuilder $builder The builder
     */
    public function __construct(PostTableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command
     *
     * @param PageRepositoryInterface $pages Pages repository
     */
    public function handle(PageRepositoryInterface $pages)
    {
        if ($parent_id = $this->builder->getRequestValue('filter_parent'))
        {
            /* @var PageInterface $page */
            $page = $pages->find($parent_id);

            while ($page)
            {
                $title[] = $page->getTitle();
                $page    = $page->getParent();
            }

            $this->builder->setOption(
                'title',
                implode(' / ', array_reverse($title))
            );
        }
    }
}
