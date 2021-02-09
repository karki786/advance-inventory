<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('productId')->unsigned();
            $table->string('photoHash')->nullable();
            $table->string('filepath')->nullable();
            $table->string('filename')->nullable();
            $table->integer('filesize')->nullable();
            $table->integer('pictureWidth')->nullable();
            $table->integer('pictureHeight')->nullable();
            $table->integer('pictureType')->nullable();
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->integer('companyId')->unsigned();
            $table->integer('updatedBy')->unsigned();
            $table->integer('createdBy')->unsigned();
            $table->boolean('isThumbnail');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('productId')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_photos');
    }
}
