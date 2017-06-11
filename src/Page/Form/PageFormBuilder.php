<?php namespace Qooco\PppModule\Page\Form;

use Anomaly\PagesModule\Page\Contract\PageRepositoryInterface;

class PageFormBuilder extends \Anomaly\PagesModule\Page\Form\PageFormBuilder
{

    /**
     * Fires when builder built
     *
     * @param PageRepositoryInterface $pages The pages
     */
    public function onBuilt(PageRepositoryInterface $pages)
    {
        if ($page_id = $this->getRequestValue('parent'))
        {
            if (!$parent = $pages->find($page_id))
            {
                abort(404, 'Can\'t create post for non existing page!');
            }

            $this->getFormField('theme_layout')
                ->setValue($parent->getDefaultPageLayout());

            $this->getFormField('default_page_layout')
                ->setValue($parent->getDefaultPageLayout());

            $this->getFormField('default_post_type')
                ->setValue($parent->getDefaultPostType());
        }
    }
}
