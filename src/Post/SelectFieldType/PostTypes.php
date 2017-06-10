<?php namespace Qooco\PppModule\Post\SelectFieldType;

use Anomaly\PostsModule\Type\Contract\TypeRepositoryInterface;
use Anomaly\SelectFieldType\SelectFieldType;

class PostTypes
{
    /**
     * Handle the command
     *
     * @param SelectFieldType         $fieldType
     * @param TypeRepositoryInterface $typeRepository
     */
    public function handle(
        SelectFieldType $fieldType,
        TypeRepositoryInterface $typeRepository
    )
    {
        $fieldType->setOptions(
            $typeRepository->all()->pluck('name', 'id')->all()
        );
    }
}
