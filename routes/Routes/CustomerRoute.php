<?php

/** Customer Route  */

Route::resource('customer', 'CustomerController');

Route::get('customer/items/filter', 'CustomerController@table');

/**Additional Routes**/
Route::get('customer/item/deleted', 'CustomerController@getDeleted');
Route::get('Customer/item/restore/{id}', 'CustomerController@restore');
Route::get('customer/contacts/{id}', 'CustomerController@getContacts');
Route::get('customer/view/{id}', 'CustomerController@getOpenItems');
Route::get('customer/stock/export', 'CustomerController@getReport');
Route::get('customer/statement/view/{id}', 'CustomerController@getStatement');
