<?php namespace Qooco\PppModule\Post\Table;

use Anomaly\PagesModule\Page\Contract\PageRepositoryInterface;
use Anomaly\SelectFieldType\SelectFieldType;
use Qooco\PppModule\Post\Table\Command\ModifyTableFilters;
use Qooco\PppModule\Post\Table\Command\ModifyTableColumns;

class PostTableBuilder extends \Anomaly\PostsModule\Post\Table\PostTableBuilder
{

    /**
     * @param PageRepositoryInterface $pages
     */
    public function onReady(PageRepositoryInterface $pages)
    {
        $this->dispatch(new ModifyTableFilters($this));
        $this->dispatch(new ModifyTableColumns($this));

        if ($parent_id = $this->getRequestValue('filter_parent'))
        {
            $page = $pages->find($parent_id);

            //$this->setOption('title', $page->title.' '.$page->path);
            $title[] = $page->getTitle();
            $parent  = $page->getParent();

            while ($parent)
            {
                $title[] = $parent->getTitle();
                $parent  = $parent->getParent();
            }

            $this->setOption('title', join(' / ', array_reverse($title)));
        }
    }
}
