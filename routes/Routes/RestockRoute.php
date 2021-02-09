<?php

/** Restock Route  */

Route::resource('restock', 'RestockController');
Route::get('restock/filter/items', 'RestockController@table');


/**Additional Routes**/
Route::get('restock/stock/deleted', 'RestockController@getDeleted');
Route::get('restock/stock/restore/{id}', 'RestockController@restore');
Route::get('restock/stock/export', 'RestockController@export');
Route::post('restock/upload/docs', 'RestockController@uploadDocs');
Route::get('restock/stock/defective', 'RestockController@getDefective');
Route::get('restock/stock/download', 'RestockController@getDownload');