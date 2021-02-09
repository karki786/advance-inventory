<?php

/** Sales Order Route  */

Route::resource('sales', 'SalesOrderController');
Route::get('sales/items/filter', 'SalesOrderController@table');
Route::resource('sl/api', 'Api\SalesOrderItemController');
Route::get('sl/api/validate/item', 'Api\SalesOrderItemController@validateInventory');

/**Additional Routes**/
Route::get('sales/stock/export', 'SalesOrderController@getReport');
Route::get('sales/stock/deleted', 'SalesOrderController@getDeleted');
Route::delete('sales/stock/delete/{id}', 'SalesOrderController@destroyItem');
Route::get('sales/stock/restore/{id}', 'SalesOrderController@restore');
