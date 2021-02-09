<?php

/** Invoice Route  */

Route::resource('invoice', 'InvoiceController');
Route::resource('inv/api', 'Api\InvoiceItemController');
Route::get('inv/api/validate/item', 'Api\InvoiceItemController@validateInventory');


Route::get('invoice/items/filter', 'InvoiceController@table');
/**Additional Routes**/
Route::get('invoice/api/getproduct/{id}/{type}/{currency}', 'InvoiceController@getInvoiceItem');
Route::get('invoice/api/getproductscan/{barcode}/{currency}', 'InvoiceController@getBarcodeScan');
Route::get('invoice/api/getproducts', 'InvoiceController@getInvoiceProducts');
Route::get('invoice/stock/deleted', 'InvoiceController@getDeleted');
Route::get('invoice/stock/restore/{id}', 'InvoiceController@restore');
Route::get('invoice/stock/export', 'InvoiceController@getReport');
Route::delete('invoice/stock/delete/{id}', 'InvoiceController@destroyItem');
