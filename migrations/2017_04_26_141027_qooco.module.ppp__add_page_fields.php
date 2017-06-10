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
        $default_page_layout = $this->fields()->create([
            'slug'      => 'default_page_layout',
            'namespace' => 'ppp',
            'type'      => 'anomaly.field_type.select',
            'config'    => [
                'handler' => 'Anomaly\SelectFieldType\Handler\Layouts@handle',
            ],
            'en'        => [
                'name' => 'Default Child Page Layout',
            ],
        ]);

        $default_post_type = $this->fields()->create([
            'slug'      => 'default_post_type',
            'namespace' => 'ppp',
            'type'      => 'anomaly.field_type.select',
            'config'    => [
                'default_value' => 1,
                'handler'       => 'Qooco\PppModule\Post\SelectFieldType\PostTypes@handle',
            ],
            'en'        => [
                'name' => 'Default Child Post Type',
            ],
        ]);

        $pages = $this->streams()->findBySlugAndNamespace('pages', 'pages');

        $this->assignments()->create([
            'field'    => $default_page_layout,
            'stream'   => $pages,
            'required' => false,
        ]);

        $this->assignments()->create([
            'field'    => $default_post_type,
            'stream'   => $pages,
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
        if ($default_page_layout = $this->fields()->findBySlugAndNamespace(
            'default_page_layout',
            'ppp'
        ))
        {
            $default_page_layout->delete();
        }

        if ($default_post_type = $this->fields()->findBySlugAndNamespace(
            'default_post_type',
            'ppp'
        ))
        {
            $default_post_type->delete();
        }
    }
}
