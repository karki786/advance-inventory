<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string("supplierName");
            $table->string("address")->nullable();
            $table->string("location")->nullable();
            $table->string("website")->nullable();
            $table->boolean("isBlocked")->default(0);
            $table->boolean("isApproved")->default(1);
            $table->string("email")->nullable();
            $table->longText("phone")->nullable();
            $table->longText("remarks")->nullable();
            $table->decimal("supplierDiscount")->nullable();
            $table->text("supplies")->nullable();
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
        Schema::drop('suppliers');
    }

}
