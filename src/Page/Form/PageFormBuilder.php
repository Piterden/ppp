<?php namespace Qooco\PppModule\Page\Form;

use Anomaly\PagesModule\Page\Contract\PageRepositoryInterface;

class PageFormBuilder extends \Anomaly\PagesModule\Page\Form\PageFormBuilder
{

    /**
     * { function_description }
     */
    public function onBuilt()
    {
        if ($page_id = request('parent'))
        {
            $parent = app(PageRepositoryInterface::class)->find($page_id);

            if (!$parent)
            {
                abort(404, 'Can\'t create post for non existing page!');
            }

            $form = $this->getForm();

            $form->getField('theme_layout')->setValue($parent->default_page_layout);
            $form->getField('default_page_layout')->setValue($parent->default_page_layout);
            $form->getField('default_post_type')->setValue($parent->default_post_type);
        }
    }
}
