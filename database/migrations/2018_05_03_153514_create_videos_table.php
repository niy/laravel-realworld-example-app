<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->string('id', 36);
            $table->unsignedInteger('article_id');
            $table->string('url');
            $table->string('thumbnail_url');
            $table->enum('upload_status', [
                \App\Video::UPLOAD_STATUS_UPLOADED,
                \App\Video::UPLOAD_STATUS_CONVERTED,
                \App\Video::UPLOAD_STATUS_FAILED
            ]);
            $table->timestamps();

            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelete('cascade');

            $table->unique('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
