<?php

/** Supplier  Route  */

Route::resource('supplier', 'SupplierController');

Route::get('supplier/items/filter', 'SupplierController@table');

/**Additional Routes**/
Route::group(['middleware' => ['auth', 'roles'], 'roles' => ['Root', 'Administrator', 'Dispatcher', 'Requisitor', 'Purchaser']], function () {
    Route::get('supplier/stock/deleted', 'SupplierController@getDeleted');
    Route::get('supplier/stock/restore/{id}', 'SupplierController@restore');
    Route::get('supplier/stock/export', 'SupplierController@export');
});
