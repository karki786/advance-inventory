<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_audits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('productId')->unsigned();
            $table->string('stockOperation')->nullable();
            $table->text('oldValues');
            $table->text('newValues');
            $table->text('narration');
            $table->double('oldQuantity', 16, 2)->nullable();
            $table->double('newQuantity')->nullable();
            $table->string('username')->nullable();
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
        Schema::dropIfExists('stock_audits');
    }
}
