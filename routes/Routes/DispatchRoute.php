<?php

/** Dispatch Route  */

Route::resource('dispatch', 'DispatchController');

Route::get('dispatch/items/filter', 'DispatchController@table');
Route::get('api/dispatch/item/{id}', 'DispatchController@getDispatchItem');
/**Additional Routes**/
Route::group(['middleware' => ['auth']], function () {
    Route::get('dispatch/stock/deleted', 'DispatchController@getDeleted');
    Route::get('dispatch/stock/defective', 'DispatchController@getDefective');
    Route::get('dispatch/stock/restore/{id}', 'DispatchController@restore');
    Route::get('dispatch/stock/export', 'DispatchController@export');
    Route::get('dispatch/{id}', 'DispatchController@show');
});
