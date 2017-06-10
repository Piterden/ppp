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

        $parent = $this->fields()->findBySlugAndNamespace('parent','pages');
        $path = $this->fields()->findBySlugAndNamespace('path','pages');

        $assignments = $this->assignments();

        $assignments->create(
            [
                'field'    => $parent,
                'stream'   => $stream,
                'required' => false,
            ]
        );

        $assignments->create(
            [
                'field'    => $path,
                'stream'   => $stream,
                'required' => false,
            ]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
