<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('companyName')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('defaultCurrency')->nullable();
            $table->string('companySlogan')->nullable();
            $table->string('street')->nullable();
            $table->string('zipCode')->nullable();
            $table->string('phone')->nullable();
            $table->string('defaultLpoTaxAmmount')->nullable();
            $table->string('lpoNumberingFormat')->nullable();
            $table->string('salesOrderNumberingFormat')->nullable();
            $table->string('invoiceNumberingFormat')->nullable();
            $table->string('receiptNumberingFormat')->nullable();
            $table->string('purchaseOrderFormat')->nullable();
            $table->string('companyCliReports')->nullable();
            $table->boolean('enableBetaFeatures')->default(0);
            $table->boolean('enableStaffDispatch')->default(1);
            $table->integer('userToRunCron')->nullable();
            $table->string('logo')->nullable();
            $table->string('homepage')->nullable();
            $table->string("language")->default("en");
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
        Schema::drop('companies');
    }
}
