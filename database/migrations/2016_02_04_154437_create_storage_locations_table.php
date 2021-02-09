<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('whsId')->unsigned();
            $table->string('binCode')->nullable();
            $table->string('binDescription')->nullable();
            $table->boolean('binDisabled')->nullable();
            $table->string('binBarcode')->nullable();
            $table->integer('binMaxLevel')->nullable();
            $table->double('binMaxWeight')->nullable();
            $table->integer('companyId')->unsigned();
            $table->integer('updatedBy')->unsigned();
            $table->integer('createdBy')->unsigned();
            $table->text('hash')->nullable();
            $table->foreign('whsId')
                ->references('id')->on('warehouses')
                ->onDelete('cascade');
            $table->softDeletes();
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
        Schema::drop('storage_locations');
    }
}
