<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salesOrderId')->unsigned()->nullable();
            $table->string('invoiceNo')->nullable();
            $table->integer('contactId')->unsigned()->nullable();
            $table->integer('customerId')->unsigned();
            $table->string('customerText')->nullable();
            $table->integer('salesPersonId')->unsigned()->nullable();
            $table->text('salesPersonText')->nullable();
            $table->boolean('paid')->nullable();
            $table->date('dueDate')->nullable();
            $table->date('invoiceDate')->nullable();
            $table->text('invoiceNotes')->nullable();
            $table->integer('currencyTypeId')->unsigned()->nullable();
            $table->text('currencyTypeText')->nullable();
            $table->string('paymentMethod')->nullable();
            $table->string('paymentTerms')->nullable();
            $table->foreign('contactId')
                ->references('id')->on('customer_contacts')
                ->onDelete('cascade');
            $table->foreign('customerId')
                ->references('id')->on('customers')
                ->onDelete('cascade');
            $table->foreign('salesPersonId')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('currencyTypeId')
                ->references('id')->on('countries')
                ->onDelete('cascade');
            $table->foreign('salesOrderId')
                ->references('id')->on('sales_orders')
                ->onDelete('cascade');
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
        Schema::drop('invoices');
    }
}
