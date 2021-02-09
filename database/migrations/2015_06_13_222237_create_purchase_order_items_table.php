<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lpoId')->unsigned()->nullable();
            $table->integer('productId')->unsigned()->nullable();
            $table->boolean('usesMultipleStorage')->nullable();
            $table->string('productDescription')->nullable();
            $table->double('amount', 15, 2)->nullable();
            $table->double('unitCost', 15, 2)->nullable();
            $table->float('discount')->nullable();
            $table->boolean('taxable')->default(1);
            $table->double('total', 15, 2)->nullable();
            $table->double('tax', 15, 2)->nullable();
            $table->double('taxRate', 15, 2)->nullable();
            $table->boolean('fullDelivery')->default(0);
            $table->boolean('partDelivery')->default(0);
            $table->float('delivered')->default(0);
            $table->integer('companyId')->unsigned();
            $table->integer('updatedBy')->unsigned();
            $table->integer('createdBy')->unsigned();
            $table->foreign('lpoId')
                ->references('id')->on('purchase_orders')
                ->onDelete('cascade');
            $table->foreign('productId')
                ->references('id')->on('products')
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
        Schema::drop('purchase_orders_items');
    }
}
