<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('whsName')->nullable();
            $table->string('whsStreet')->nullable();
            $table->string('whsZipCode')->nullable();
            $table->string('whsCity')->nullable();
            $table->string('whsCountry')->nullable();
            $table->string('whsState')->nullable();
            $table->string('whsBuilding')->nullable();
            $table->string('whsStoreKeeper')->nullable();
            $table->boolean('isActive');
            $table->integer('companyId')->unsigned();
            $table->integer('updatedBy')->unsigned();
            $table->integer('createdBy')->unsigned();
            $table->text('hash')->nullable();
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
        Schema::drop('warehouses');
    }
}
