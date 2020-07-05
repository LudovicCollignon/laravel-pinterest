<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameImagesTagsToImageTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('image_tags')){
            Schema::table('image_tags', function (Blueprint $table) {
                Schema::rename('images_tags', 'image_tags');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('image_tags', function (Blueprint $table) {
            //
        });
    }
}
