<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryRunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_runs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staffId')->unsigned()->nullable();
            $table->integer('shippingZone')->unsigned()->nullable();
            $table->dateTime('returnTime')->nullable();
            $table->dateTime('dispatchTime')->nullable();
            $table->integer('companyId')->unsigned();
            $table->integer('updatedBy')->unsigned();
            $table->integer('createdBy')->unsigned();
            $table->boolean('delivered')->default(0);
            $table->foreign('staffId')
                ->references('id')->on('staff')
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
        Schema::dropIfExists('delivery_runs');
    }
}
