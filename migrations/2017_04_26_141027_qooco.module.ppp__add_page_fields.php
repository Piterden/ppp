<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class QoocoModulePppAddPageFields extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $stream = $this->streams()->findBySlugAndNamespace('pages', 'pages');

        $field = $this->fields()->create([
            'slug'      => 'default_page_layout',
            'namespace' => 'ppp',
            'type'      => 'anomaly.field_type.select',
            'config'    => [
                'handler' => 'layouts',
            ],
            'en'        => [
                'name' => 'Default Child Page Layout',
            ],
        ]);

        $this->assignments()->create([
            'field'    => $field,
            'stream'   => $stream,
            'required' => false,
        ]);

        $field = $this->fields()->create([
            'slug'      => 'default_post_type',
            'namespace' => 'ppp',
            'type'      => 'anomaly.field_type.select',
            'config'    => [
                'default_value' => 1,
                'handler'       => 'Qooco\PppModule\Post\Form\Handler\PostTypes@handle',
            ],
            'en'        => [
                'name' => 'Default Child Post Type',
            ],
        ]);

        $this->assignments()->create([
            'field'    => $field,
            'stream'   => $stream,
            'required' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $stream = $this->streams()->findBySlugAndNamespace('pages', 'pages');

        if ($field = $this->fields()->findBySlugAndNamespace(
            'default_page_layout',
            'ppp'
        ))
        {
            if ($assignment = $this->assignments()->findByStreamAndField($stream, $field))
            {
                $this->assignments()->delete($assignment);
            }

            $this->fields()->delete($field);
        }

        if ($field = $this->fields()->findBySlugAndNamespace(
            'default_post_type',
            'ppp'
        ))
        {
            if ($assignment = $this->assignments()->findByStreamAndField($stream, $field))
            {
                $this->assignments()->delete($assignment);
            }

            $this->fields()->delete($field);
        }
    }
}
