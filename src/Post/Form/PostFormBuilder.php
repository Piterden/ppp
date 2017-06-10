<?php namespace Qooco\PppModule\Post\Form;

use Anomaly\PagesModule\Page\Contract\PageRepositoryInterface;

class PostFormBuilder extends \Anomaly\PostsModule\Post\Form\PostFormBuilder
{

    /**
     * @param PostFormBuilder $this
     */
    public function onBuilt()
    {
        if ($page_id = request('parent'))
        {
            $this->getForm()->getField('parent')->setValue($page_id);
            $parent = app(PageRepositoryInterface::class)->find($page_id);

            if (!$parent)
            {
                abort(404, 'Can\'t create post for non existing page!');
            }
        }
        else
        {
            $parent = $this->getFormEntry()->parent;
        }

        $path = ($parent ? url(trim('/' . $parent->path, '/')) : url('/')) . '/';

        /**
         * @var SlugFieldType
         */
        $this->getForm()->getField('slug')->configSet('prefix', $path);

        /**
         * @var RelationshipFieldType
         */
        $this->getForm()->getField('parent')->configSet('mode', 'lookup');
    }
}
