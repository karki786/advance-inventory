<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoiceId')->unsigned();
            $table->integer('productId')->unsigned();
            $table->integer('binLocation')->unsigned();
            $table->string('productDescription')->nullable();
            $table->double('quantity', 15, 2)->nullable();
            $table->double('returned', 15, 2)->nullable();
            $table->double('sellingPrice', 15, 2)->nullable();
            $table->double('convertedPrice', 15, 2)->nullable();
            $table->double('convertedRate', 15, 2)->nullable();
            $table->double('tax', 15, 2)->nullable();
            $table->double('taxRate', 15, 2)->nullable();
            $table->double('total', 15, 2)->nullable();
            $table->double('discount', 15, 2)->nullable();
            $table->string('locationHash')->nullable();
            $table->text('hash')->nullable();
            $table->boolean('taxable');
            $table->foreign('productId')
                ->references('id')->on('products')
                ->onDelete('cascade');
            $table->foreign('invoiceId')
                ->references('id')->on('invoices')
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
        Schema::drop('invoice_items');
    }
}
