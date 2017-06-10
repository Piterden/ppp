<?php namespace Qooco\PppModule\Post\Form;

use Anomaly\PostsModule\Post\Form\PostEntryFormBuilder;

/**
 * Class PostEntryFormSections
 *
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 *
 * @link          http://pyrocms.com/
 */
class PostEntryFormSections extends \Anomaly\PostsModule\Post\Form\PostEntryFormSections
{

    /**
     * Handle the form sections.
     *
     * @param PostEntryFormBuilder $builder
     */
    public function handle(PostEntryFormBuilder $builder)
    {
        parent::handle($builder);

        $sections = $builder->getSections();

        array_set(
            $sections,
            'post.tabs.organization.fields',
            array_merge(
                ['post_parent'],
                array_get($sections, 'post.tabs.organization.fields')
            )
        );

        $builder->setSections($sections);
    }
}
