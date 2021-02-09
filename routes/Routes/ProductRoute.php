<?php

/** Product Route  */

Route::resource('product', 'ProductController');
Route::get('products/items/filter', 'ProductController@table');

/**Additional Routes**/
Route::group(['middleware' => ['auth']], function () {
    Route::get('product/stock/finished', 'ProductController@getOutOfStock');
    Route::get('product/api/location/{id}', 'ProductController@getLocation');
    Route::get('product/stock/deleted', 'ProductController@getDeleted');
    Route::get('product/stock/warning', 'ProductController@getBelowLevels');
    Route::get('product/stock/restore/{id}', 'ProductController@restore');
    Route::post('product/upload/photo/{id}', 'ProductController@uploadPhoto');
    Route::get('product/stock/export', 'ProductController@export');
    Route::get('product/stock/products', 'ProductController@getProducts');
    Route::get('product/stock/import', 'ProductController@import');
    Route::post('product/stock/upload', 'ProductController@uploadData');
    Route::get('product/stock/barcode/{id}', 'ProductController@barcode');
});