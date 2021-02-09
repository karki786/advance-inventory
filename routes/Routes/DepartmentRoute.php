<?php

/** Department Route  */

Route::resource('department', 'DepartmentController');
Route::get('department/items/filter', 'DepartmentController@table');

/**Additional Routes**/
Route::get('department/stock/deleted', 'DepartmentController@getDeleted');
Route::get('department/stock/restore/{id}', 'DepartmentController@restore');
Route::get('department/stock/export', 'DepartmentController@export');
Route::get('department/{id}', 'DepartmentController@show');
Route::get('department/items/filter', 'DepartmentController@table');
