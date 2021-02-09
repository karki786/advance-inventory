<?php

/** User Route  */

Route::resource('user', 'UserController');
Route::get('user/items/filter', 'UserController@table');

/**Additional Routes**/
Route::get('user/stock/deleted', 'UserController@getDeleted');
Route::get('user/stock/restore/{id}', 'UserController@restore');
Route::post('/user/upload/photo', 'UserController@uploadAvatar');
Route::resource('roles', 'UserRolesController');
Route::get('user/stock/export', 'UserController@export');
Route::post('user/stock/import', 'UserController@import');
Route::get('user/stock/import', 'UserController@import');

