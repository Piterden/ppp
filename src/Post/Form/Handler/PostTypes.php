<?php namespace Qooco\PppModule\Post\Form\Handler;

use Anomaly\PostsModule\Type\Contract\TypeRepositoryInterface;
use Anomaly\SelectFieldType\SelectFieldType;

class PostTypes
{

    /**
     * Handle the command
     *
     * @param SelectFieldType         $field
     * @param TypeRepositoryInterface $types
     */
    public function handle(SelectFieldType $field, TypeRepositoryInterface $types)
    {
        $field->setOptions($types->all()->pluck('name', 'id')->all());
    }
}
