<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string("appTheme")->default('skin-purple');
            $table->string("blackColor")->default("#494945");
            $table->string("cyanColor")->default("#00FFFF");
            $table->string("magentaColor")->default("#FF00FF");
            $table->string("yellowColor")->default("#FFFF00");
            $table->string("barGraphdefaultColor")->default("#494945");
            $table->boolean("useAreaForSingleColor")->default(true);
            $table->integer('printersDowntime')->default(24);
            $table->integer('dailyMinimum')->default(0);
            $table->integer('dailyMaximum')->default(2750);
            $table->integer('paperReam')->default(500);
            $table->integer('paginationDefault')->default(10);
            $table->integer("userId");
            $table->integer("staffId");
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
        Schema::drop('settings');
    }

}
