<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salesOrderId')->unsigned();
            $table->integer('productId')->unsigned();
            $table->integer('binLocation')->unsigned();
            $table->string('productDescription')->nullable();
            $table->double('quantity', 15, 2)->default(0);
            $table->double('sellingPrice', 15, 2)->nullable();
            $table->double('convertedPrice', 15, 2)->nullable();
            $table->double('convertedRate', 15, 2)->nullable();
            $table->double('tax', 15, 2)->nullable();
            $table->double('taxRate', 15, 2)->nullable();
            $table->double('total', 15, 2)->nullable();
            $table->double('discount', 15, 2)->nullable();
            $table->boolean('taxable')->nullable();
            $table->double('returned', 15, 2)->nullable();
            $table->string('locationHash')->nullable();
            $table->boolean('onHold')->boolean(0);
            $table->text('hash');
            $table->foreign('productId')
                ->references('id')->on('products')
                ->onDelete('cascade');
            $table->foreign('salesOrderId')
                ->references('id')->on('sales_orders')
                ->onDelete('cascade');
            $table->integer('companyId')->unsigned();
            $table->integer('updatedBy')->unsigned();
            $table->integer('createdBy')->unsigned();
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
        Schema::drop('sales_order_items');
    }
}
