<?php namespace Qooco\PppModule\Post\Form;

use Anomaly\PostsModule\Post\Form\PostEntryFormSections;

class PostEntryFormBuilder extends \Anomaly\PostsModule\Post\Form\PostEntryFormBuilder
{

    /**
     * @param PostEntryFormBuilder $this
     */
    public function onReady()
    {
        (new PostEntryFormSections())->handle($this);
        $sections = $this->getSections();
        array_unshift($sections['post']['tabs']['organization']['fields'], 'post_parent');
        $this->setSections($sections);
    }
}
