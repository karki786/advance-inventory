<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseOrdersTable extends Migration
{
    /**purchase
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supplierId');
            $table->string('supplierName')->nullable();
            $table->date('dateOfDelivery')->nullable();
            $table->string('termsOfPayment')->nullable();
            $table->date('deliverBy')->nullable();
            $table->boolean('fullDelivery')->default(0);
            $table->boolean('partDelivery')->default(0);
            $table->boolean('isFavourite')->default(0);
            $table->integer('departmentId')->nullable();
            $table->string('favouriteName')->nullable();
            $table->string('lpoNumber')->nullable();
            $table->string('internalRefNo')->nullable();
            $table->string('vatTaxAmount')->nullable();
            $table->string("company")->nullable();
            $table->string("lpoCurrencyType")->nullable();
            $table->string("prRequestNo")->nullable();
            $table->text("remarks")->nullable();
            $table->integer('lpoStatus')->nullable();
            $table->dateTime('lpoApprovedOn')->nullable();
            $table->date('lpoDate')->nullable();
            $table->text('rejectionReason')->nullable();
            $table->text('hash')->nullable();
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
        Schema::drop('purchase_orders');
    }
}
