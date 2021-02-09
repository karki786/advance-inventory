<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('roleId')->unsigned();
            $table->string('model')->nullable();
            $table->boolean('canCreate')->default(0);
            $table->boolean('canGlance')->default(0);
            $table->boolean('canView')->default(0);
            $table->boolean('canUpdate')->default(0);
            $table->boolean('canDelete')->default(0);
            $table->foreign('roleId')
                ->references('id')->on('roles')
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
        Schema::dropIfExists('module_permissions');
    }
}
