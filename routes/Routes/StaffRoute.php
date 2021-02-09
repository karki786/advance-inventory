<?php

/** Staff Route  */

Route::resource('staff', 'StaffController');
Route::get('staff/items/filter', 'StaffController@table');

/**Additional Routes**/
Route::get('staff/get/all', 'StaffController@getStaff');
Route::get('staff/stock/deleted', 'StaffController@getDeletedStaff');
Route::get('staff/stock/restore/{id}', 'StaffController@restoreDeletedStaff');
Route::post('staff/create/ajax', 'StaffController@createStaff');
