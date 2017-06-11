<?php namespace Qooco\PppModule\Page\Tree\Command;

use Anomaly\PagesModule\Type\Contract\TypeInterface;
use Anomaly\PagesModule\Type\Contract\TypeRepositoryInterface;

/**
 * Class BuildDropdown
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Qooco <qooco.a@gmail.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class BuildDropdown
{

    /**
     * Handle the command
     *
     * @param TypeRepositoryInterface $types The types
     */
    public function handle(TypeRepositoryInterface $types)
    {
        $post_types = $types->all();

        $dropdown = $post_types->map(
            function (TypeInterface $type)
            {
                $id     = $type->getId();
                $name   = $type->getName();
                $suffix = $type->id == 1 ? ' Post' : '';

                return [
                    'text'       => "Add {$name}{$suffix}",
                    'attributes' => [
                        'href' => "/admin/posts/create?type={$id}&parent={entry.id}",
                    ],
                ];
            }
        )->toArray();
    }
}
