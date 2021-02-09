<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('receiptId')->unsigned();
            $table->integer('productId')->unsigned();
            $table->integer('binLocation')->unsigned();
            $table->string('productDescription');
            $table->double('quantity', 15, 2);
            $table->double('returned', 15, 2);
            $table->double('sellingPrice', 15, 2);
            $table->double('convertedPrice', 15, 2);
            $table->double('convertedRate', 15, 2);
            $table->double('tax', 15, 2);
            $table->double('taxRate', 15, 2);
            $table->double('total', 15, 2);
            $table->double('discount', 15, 2);
            $table->boolean('taxable');
            $table->foreign('productId')
                ->references('id')->on('products')
                ->onDelete('cascade');
            $table->foreign('receiptId')
                ->references('id')->on('receipts')
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
        Schema::dropIfExists('receipt_items');
    }
}
