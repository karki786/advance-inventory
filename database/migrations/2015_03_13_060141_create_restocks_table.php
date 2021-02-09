<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestocksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("productID");
            $table->longText("productName");
            $table->integer("departmentUse");
            $table->double("unitCost", 15, 2)->default(0);
            $table->double("itemCost", 15, 2)->default(0);
            $table->double("amount", 15, 2);
            $table->longText("invoice")->nullable();
            $table->longText("deliveryNote")->nullable();
            $table->integer("supplierID")->nullable();
            $table->integer("productLocationId")->nullable();
            $table->integer("lpoId")->nullable();
            $table->boolean("isDamagedReturned")->default(0);
            $table->text("defectiveRemark")->nullable();
            $table->boolean("isMistakeRestock")->default(0);
            $table->longText("remarks")->nullable();
            $table->longText("restockDocs")->nullable();
            $table->integer("receivedBy")->nullable();
            $table->longText('defectRemark')->nullable();
            $table->integer("warehouseId")->nullable();
            $table->integer("binLocationId")->nullable();
            $table->text('hash')->nullable();
            $table->text('locationHash')->nullable();
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
        Schema::drop('restocks');
    }

}
