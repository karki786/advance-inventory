<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 800);
            $table->string("salutation")->nullable();
            $table->string("contactName")->nullable();
            $table->string("jobTitle")->nullable();
            $table->string("avatar")->nullable();
            $table->integer('departmentId')->nullable();
            $table->boolean('verified')->default(false);
            $table->rememberToken();
            $table->integer('role_id')->unsigned()->default(1);
            $table->integer('companyId')->unsigned();
            $table->string('userIdHash', 100)->nullable();
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
        Schema::drop('users');
    }

}
