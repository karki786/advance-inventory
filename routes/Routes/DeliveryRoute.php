<?php

/** Delivery Route  */

Route::resource('delivery', 'DeliveryController');


/**Additional Routes**/
Route::get('delivery/zone/{id}', 'DeliveryController@getDeliveries');
Route::get('delivery/orders/{id}', 'DeliveryController@getDeliveryItems');
Route::post('delivery/return/update', 'DeliveryController@updateUndeliveredItems');
Route::get('delivery/stock/export', 'DeliveryController@export');
Route::get('delivery/run/finalize/{id}', 'DeliveryController@finalizeDelivery');
Route::get('delivery/run/invoice/{id}', 'DeliveryController@invoiceDeliveries');