<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customerId')->unsigned();
            $table->string('customerName')->nullable();
            $table->string('telephoneNumber')->nullable();
            $table->string('mobileNumber')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('email')->nullable();

            #Contacts
            $table->string('street')->nullable();
            $table->string('zipCode')->nullable();
            $table->string('addressName1')->nullable();
            $table->string('addressName2')->nullable();
            $table->string('houseno')->nullable();
            $table->string('societyname');
            $table->text('hash')->nullable();
            $table->foreign('customerId')
                ->references('id')->on('customers')
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
        Schema::drop('customer_contacts');
    }
}
