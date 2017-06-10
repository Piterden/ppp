<?php namespace Qooco\PppModule\Post\Table\Command;

use Qooco\PppModule\Post\Table\PostTableBuilder;

/**
 * Class for modify table columns.
 */
class ModifyTableColumns
{

    /**
     * Table builder
     *
     * @var mixed
     */
    protected $builder;

    /**
     * Create new instance of ModifyTableColumns class
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
        $parent_id = $this->builder->getRequestValue('filter_parent');
        $columns   = $this->builder->getColumns();

        if ($idx = array_search('category', $columns))
        {
            if ($parent_id)
            {
                array_forget($columns, $idx);
            }
            else
            {
                array_set($columns, $idx, 'path');
            }
        }

        $this->builder->setColumns($columns);
    }
}
