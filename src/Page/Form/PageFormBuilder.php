<?php namespace Qooco\PppModule\Page\Form;

use Anomaly\PagesModule\Page\Contract\PageRepositoryInterface;

/**
 * Class PageFormBuilder
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Qooco <qooco.a@gmail.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
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
