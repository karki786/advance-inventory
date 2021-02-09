<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('productName');
            $table->string('location');
            $table->string('productSerial')->nullable();
            $table->string('productWeight')->nullable();
            $table->string('productSku')->nullable();
            $table->double('amount', 15, 2)->default(0);
            $table->double("unitCost", 15, 2)->nullable();
            $table->double("sellingPrice", 15, 2)->nullable();
            $table->double("productTax", 15, 2)->nullable();
            $table->double('productTaxRate', 15, 2)->nullable();
            $table->decimal('reorderAmount')->nullable();
            $table->integer('maximumOrderAmount')->nullable();
            $table->date('expiryDate')->nullable();
            $table->longText('barcode')->nullable();
            $table->longText('qrcode')->nullable();
            $table->longText('productImage')->nullable();
            $table->boolean('canAutoOrder')->nullable();
            $table->string('autoOrderEmail')->nullable();
            $table->longText('emailFormat')->nullable();
            $table->string('barcodeFileName')->nullable();
            $table->string('qrcodeFileName')->nullable();
            $table->string('productMeasurementUnit')->nullable();
            $table->string('productBrand')->nullable();
            $table->string('productCurrency')->nullable();
            $table->string('productManufacturer')->nullable();
            $table->string('productBarcode')->nullable();
            $table->string('productModel')->nullable();
            $table->string('productProductionDate')->nullable();
            $table->text('hash')->nullable();
            $table->boolean('usesMultipleStorage')->default(0);
            //Returnables Format
            $table->string('categoryName')->nullable();
            $table->integer('categoryId')->nullable();
            $table->text('productSpecification')->nullable();
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
        Schema::drop('products');
    }

}
