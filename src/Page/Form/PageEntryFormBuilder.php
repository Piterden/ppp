<?php namespace Qooco\PppModule\Page\Form;

use Anomaly\PagesModule\Page\Form\PageEntryFormSections;

class PageEntryFormBuilder extends \Anomaly\PagesModule\Page\Form\PageEntryFormBuilder
{

    /**
     * { function_description }
     */
    public function onReady()
    {
        (new PageEntryFormSections())->handle($builder);

        $sections = $builder->getSections();

        $sections['page']['tabs']['options']['fields'][] = 'page_default_page_layout';
        $sections['page']['tabs']['options']['fields'][] = 'page_default_post_type';

        $builder->setSections($sections);
    }
}
