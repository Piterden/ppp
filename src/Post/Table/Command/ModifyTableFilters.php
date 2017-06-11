<?php namespace Qooco\PppModule\Post\Table\Command;

use Anomaly\PagesModule\Page\Contract\PageRepositoryInterface;
use Qooco\PppModule\Post\Table\PostTableBuilder;

/**
 * Class ModifyTableFilters
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Qooco <qooco.a@gmail.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class ModifyTableFilters
{

    /**
     * Table builder
     *
     * @var mixed
     */
    protected $builder;

    /**
     * Create new instance of ModifyTableFilters class
     *
     * @param PostTableBuilder $builder The builder
     */
    public function __construct(PostTableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command
     */
    public function handle()
    {
        $filters = $this->builder->getFilters();

        if ($idx = array_search('category', $filters))
        {
            array_forget($filters, $idx);

            array_set(
                $filters,
                'parent',
                [
                    'filter'  => 'select',
                    /* @var PageRepositoryInterface $pages */
                    'options' => function (PageRepositoryInterface $pages)
                    {
                        return $pages->newQuery()->whereHas('posts')->get()
                            ->pluck('path', 'id')->sort()->all();
                    },
                ]
            );
        }

        $this->builder->setFilters($filters);
    }
}
