<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->text('orderNo');
            $table->integer('customerId')->unsigned()->nullable();
            $table->integer('contactId')->unsigned()->nullable();
            $table->string('customerText')->nullable();
            $table->boolean('onHold')->nullable();
            $table->integer('salesPersonId')->unsigned()->nullable();
            $table->text('salesPersonText')->nullable();
            $table->integer('currencyTypeId')->unsigned()->nullable();
            $table->text('currencyTypeText')->nullable();
            $table->string('paymentMethod')->nullable();
            $table->string('paymentTerms')->nullable();
            $table->integer('subscriptionId')->unsigned()->nullable();
            $table->integer('shippingZone')->unsigned()->nullable();
            $table->boolean('delivery')->default(0);
            $table->boolean('approved')->default(0);
            $table->boolean('onDelivery')->default(0);
            $table->boolean('invoiced')->default(0);
            $table->boolean('delivered')->default(0);
            $table->string('remarks')->nullable();
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
        Schema::drop('sales_orders');
    }
}
