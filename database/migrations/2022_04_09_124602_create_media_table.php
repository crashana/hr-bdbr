<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('media_type')->nullable();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->index(['media_type', 'media_id']);
            $table->string('collection_name')->default('default')->nullable();
            $table->string('path');
            $table->string('name')->nullable();
            $table->string('file_name');
            $table->string('label')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('extension', 11)->nullable();
            $table->unsignedInteger('ord')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
