<?php namespace Qooco\PppModule\Post\Form\Handler;

use Anomaly\PostsModule\Type\Contract\TypeRepositoryInterface;
use Anomaly\SelectFieldType\SelectFieldType;

/**
 * Class for get post types options.
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
