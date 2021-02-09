<?php

/** Invoice Route  */
/** Payments Route  */

Route::resource('payment', 'PaymentController');
Route::get('payments/items/filter', 'PaymentController@table');

/**Additional Routes**/
Route::get('payment/api/invoice/{id}', 'PaymentController@getInvoice');
Route::get('payment/group/create', 'PaymentController@groupCreate');
Route::post('payment/group/', 'PaymentController@groupSave');
Route::get('payment/api/customer/{id}', 'PaymentController@getInvoices');
Route::get('payment/api/customer/cost/{id}', 'PaymentController@getInvoicesCost');
Route::get('payment/stock/deleted', 'PaymentController@getDeleted');
Route::get('payment/stock/restore/{id}', 'PaymentController@restore');
Route::get('payment/stock/export', 'PaymentController@getReport');
