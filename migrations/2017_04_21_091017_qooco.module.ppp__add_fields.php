<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class QoocoModulePppAddFields extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $stream = $this->streams()->findBySlugAndNamespace('posts', 'posts');

        if ($field = $this->fields()->findBySlugAndNamespace('parent', 'pages'))
        {
            $this->assignments()->create(
                [
                    'field'    => $field,
                    'stream'   => $stream,
                    'required' => false,
                ]
            );
        }

        if ($field = $this->fields()->findBySlugAndNamespace('path', 'pages'))
        {
            $this->assignments()->create(
                [
                    'field'    => $field,
                    'stream'   => $stream,
                    'required' => false,
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $stream = $this->streams()->findBySlugAndNamespace('posts', 'posts');

        if ($field = $this->fields()->findBySlugAndNamespace('parent', 'pages'))
        {
            if ($assignment = $this->assignments()->findByStreamAndField($stream, $field))
            {
                $this->assignments()->delete($assignment);
            }
        }

        if ($field = $this->fields()->findBySlugAndNamespace('path', 'pages'))
        {
            if ($assignment = $this->assignments()->findByStreamAndField($stream, $field))
            {
                $this->assignments()->delete($assignment);
            }
        }
    }
}
