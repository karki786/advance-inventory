<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('invoiceId')->unsigned();
            $table->Integer('customerId')->unsigned();
            $table->boolean('downPayment')->nullable();
            $table->double('paymentAmount', 15, 2)->nullable();
            $table->string('paymentMethod')->nullable();
            $table->string('paymentDetails')->nullable();
            $table->string('paymentRemarks')->nullable();
            $table->string('paymentNarration')->nullable();
            $table->string('paymentType')->nullable();
            $table->integer('companyId')->unsigned();
            $table->integer('updatedBy')->unsigned();
            $table->integer('createdBy')->unsigned();
            $table->text('hash')->nullable();
            $table->foreign('invoiceId')
                  ->references('id')->on('invoices')
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
        Schema::drop('invoice_payments');
    }
}
