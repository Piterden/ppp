<?php namespace Qooco\PppModule\Post\Form\Handler;

use Anomaly\PostsModule\Type\Contract\TypeRepositoryInterface;
use Anomaly\SelectFieldType\SelectFieldType;

/**
 * Class PostTypes
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Qooco <qooco.a@gmail.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class PostTypes
{

    /**
     * Handle the command
     *
     * @param SelectFieldType         $fieldType
     * @param TypeRepositoryInterface $types
     */
    public function handle(SelectFieldType $fieldType, TypeRepositoryInterface $types)
    {
        $fieldType->setOptions($types->all()->pluck('name', 'id')->toArray());
    }
}
