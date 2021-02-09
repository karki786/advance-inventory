<?php

/** Category Route  */

Route::resource('/category', 'CategoryController');

/**Additional Routes**/
Route::get('category/stock/export', 'CategoryController@export');
Route::get('categories/items/filter', 'CategoryController@table');

