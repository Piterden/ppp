<?php namespace Qooco\PppModule\Page\Form;

use Anomaly\PagesModule\Page\Form\PageEntryFormBuilder;

class PageEntryFormSections extends \Anomaly\PagesModule\Page\Form\PageEntryFormSections
{

    /**
     * Handle the command
     *
     * @param PageEntryFormBuilder $builder The builder
     */
    public function handle(PageEntryFormBuilder $builder)
    {
        parent::handle($builder);

        $sections = $builder->getSections();

        array_set(
            $sections,
            'page.tabs.options.fields',
            array_merge(
                array_get($sections, 'page.tabs.options.fields'),
                [
                    'page_default_page_layout',
                    'page_default_post_type',
                ]
            )
        );

        $builder->setSections($sections);
    }
}
