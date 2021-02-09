<?php

/** Roles Route  */

Route::resource('role', 'RoleController');


Route::get('role/assign/all', 'RoleController@assignAll');


/**Additional Routes**/      