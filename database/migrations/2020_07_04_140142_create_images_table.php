<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('filename', 255)->unique();
            $table->timestamps();
        });

        // Schema::table('images', function (Blueprint $table) {
        //     $table->foreignId('user_id')->constrained();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
