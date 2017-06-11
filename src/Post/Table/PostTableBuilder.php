<?php namespace Qooco\PppModule\Post\Table;

use Qooco\PppModule\Post\Table\Command\ModifyTableColumns;
use Qooco\PppModule\Post\Table\Command\ModifyTableFilters;
use Qooco\PppModule\Post\Table\Command\SetTableTitle;

class PostTableBuilder extends \Anomaly\PostsModule\Post\Table\PostTableBuilder
{

    /**
     * @param PageRepositoryInterface $pages
     */
    public function onReady()
    {
        $this->dispatch(new ModifyTableFilters($this));
        $this->dispatch(new ModifyTableColumns($this));
        $this->dispatch(new SetTableTitle($this));
    }
}
