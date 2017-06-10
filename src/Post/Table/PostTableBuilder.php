<?php namespace Qooco\PppModule\Post\Table;

use Anomaly\PagesModule\Page\Contract\PageRepositoryInterface;
use Anomaly\SelectFieldType\SelectFieldType;

class PostTableBuilder extends \Anomaly\PostsModule\Post\Table\PostTableBuilder
{

    /**
     * @param PostTableBuilder $builder
     */
    public function onReady()
    {
        $parent_id = request('filter_parent');

        $filters = $this->getFilters();
        $columns = $this->getColumns();

        if ($idx = array_search('category', $filters))
        {
            unset($filters[$idx]);

            $filters['parent'] = [
                'filter'  => 'select',
                'options' => function (
                    SelectFieldType $fieldType,
                    PageRepositoryInterface $repository
                )
                {
                    $fieldType->setOptions(
                        $repository->newQuery()->whereHas('posts')->get()
                            ->pluck('path', 'id')->sort()->all()
                    );
                },
            ];
        }

        if ($idx = array_search('category', $columns))
        {
            if ($parent_id)
            {
                unset($columns[$idx]);
            }
            else
            {
                $columns[$idx] = 'path';
            }
        }

        $this->setFilters($filters);
        $this->setColumns($columns);

        if ($parent_id)
        {
            $page = app(PageRepositoryInterface::class)->find($parent_id);

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
