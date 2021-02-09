<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('companyName')->nullable();
            $table->string('companyEmail')->nullable();
            $table->string('email')->nullable();
            $table->string('companyCurrency')->nullable();
            $table->string('surname')->nullable();
            $table->boolean('customerType')->nullable()->boolean();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->boolean('customerVacation')->nullable()->default(0);
            $table->date('customerVacationUntil')->nullable();
            $table->string('secret')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('password')->nullable();

            #Payments
            $table->double('creditLimit', 15, 2)->nullable();
            $table->integer('days')->nullable();
            $table->double('discount', 15, 2)->nullable();

            #Account Status
            $table->boolean('active')->nullable();
            $table->string('disableReason')->nullable();

            $table->integer('companyId')->unsigned();
            $table->integer('updatedBy')->unsigned();
            $table->integer('createdBy')->unsigned();
            $table->integer('shippingZone')->nullable()->unsigned();
            $table->integer('shippingSubZone')->nullable()->unsigned();
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
        Schema::drop('customers');
    }
}
