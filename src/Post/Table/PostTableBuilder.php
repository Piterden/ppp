<?php namespace Qooco\PppModule\Post\Table;

use Qooco\PppModule\Post\Table\Command\ModifyTableColumns;
use Qooco\PppModule\Post\Table\Command\ModifyTableFilters;
use Qooco\PppModule\Post\Table\Command\SetTableTitle;

/**
 * Class PostTableBuilder
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Qooco <qooco.a@gmail.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
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
