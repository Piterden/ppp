<?php namespace Qooco\PppModule\Post\Form;

use Anomaly\PagesModule\Page\Contract\PageRepositoryInterface;

class PostFormBuilder extends \Anomaly\PostsModule\Post\Form\PostFormBuilder
{

    /**
     * @param PostFormBuilder $this
     */
    public function onBuilt(PageRepositoryInterface $pages)
    {
        if ($page_id = $this->getRequestValue('parent'))
        {
            $this->getFormField('parent')->setValue($page_id);

            if (!$parent = $pages->find($page_id))
            {
                abort(404, 'Can\'t create post for non existing page!');
            }
        }
        else
        {
            $parent = $this->getFormEntry()->parent;
        }

        $path = ($parent ? url(trim('/' . $parent->path, '/')) : url('/')) . '/';

        /* @var SlugFieldType */
        $this->getFormField('slug')->configSet('prefix', $path);

        /* @var RelationshipFieldType */
        $this->getFormField('parent')->configSet('mode', 'lookup');
    }
}
