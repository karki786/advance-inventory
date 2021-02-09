<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_credits', function (Blueprint $table) {
            $table->increments('id');
            $table->double('amount', 16, 2);
            $table->text('paymentNarration');
            $table->integer('customerId')->unsigned();
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
        Schema::dropIfExists('payment_credits');
    }
}
