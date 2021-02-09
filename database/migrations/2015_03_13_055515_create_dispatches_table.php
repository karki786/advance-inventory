<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDispatchesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("dispatchedItem")->nullable();
            $table->integer("dispatchedTo")->nullable();
            $table->integer("departmentId")->nullable();
            $table->integer("userId")->unsigned();
            $table->double("amount", 15, 2);
            $table->longText("remarks")->nullable();
            $table->boolean("isReturned")->default(0);
            $table->boolean("isDefective")->default(0);
            $table->text("defectiveRemark")->nullable();
            $table->boolean('isMistakeDispatch')->default(0);
            $table->longText('defectRemark')->nullable();
            $table->integer('warehouseId')->nullable();
            $table->integer('binLocationId')->nullable();
            $table->integer('productLocationId')->nullable();
            $table->double("totalCost", 15, 2)->nullable();
            $table->integer('companyId')->unsigned();
            $table->integer('updatedBy')->unsigned();
            $table->text('hash')->nullable();
            $table->text('productLocationHash')->nullable();
            $table->boolean('isMultipleStorage')->default(0);
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
        Schema::drop('dispatches');
    }

}
