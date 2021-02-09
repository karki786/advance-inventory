<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('productId')->unsigned();
            $table->integer('productLocation')->nullable();
            $table->string('productLocationName')->nullable();
            $table->integer('binLocation')->nullable();
            $table->string('binLocationName')->nullable();
            $table->string('productBarcode')->nullable();
            $table->string('productCurrency')->nullable();
            $table->double("unitCost", 15, 2)->nullable();
            $table->double("sellingPrice", 15, 2)->nullable();
            $table->decimal('amount')->nullable();
            $table->boolean('onHold')->default(0);
            $table->text('onHoldBy')->nullable();
            $table->text('hash')->nullable();
            $table->foreign('productId')
                ->references('id')->on('products')
                ->onDelete('cascade');
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
        Schema::drop('product_locations');
    }
}
