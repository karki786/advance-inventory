<?php
/** Warehouse Route  */

Route::resource('warehouse', 'WarehouseController');

Route::get('warehouse/bins/items', 'WarehouseController@tableDetails');
/**Additional Routes**/
Route::get('api/v1/locations/{id}', 'Api\v1\GeneralController@getLocations');
Route::get('api/v1/warehouses/{id}', 'Api\v1\GeneralController@getWarehouses');
Route::get('api/v1/binlocations/{id}/{warehouse}', 'Api\v1\GeneralController@getBinLocations');
Route::get('api/v1/binlocations_e/{id}/{warehouse}', 'Api\v1\GeneralController@getBinLocationsForEdit');
Route::get('api/v1/warehouselocations/{warehouseid}', 'Api\v1\GeneralController@getWarehouseBinLocations');
Route::get('api/v1/product/ismulti/{warehouseid}', 'Api\v1\GeneralController@getProductIsMultiLocation');



/** BinLocation  Route  */

Route::resource('warehouse/bin', 'BinLocationController');


/**Additional Routes**/
Route::get('warehouse/stock/export', 'WarehouseController@export');
Route::get('api/warehouses', 'WarehouseController@table');
Route::get('warehouse/api/locations/{id}', 'WarehouseController@getProductsTable');