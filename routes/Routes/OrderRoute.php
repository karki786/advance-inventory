<?php

/** Order Route  */

Route::resource('order', 'PurchaseOrderController');
Route::resource('pl/api', 'Api\PurchaseOrderController');

/**Additional Routes**/
Route::get('order/items/filter', 'PurchaseOrderController@table');

Route::get('order/api/reorder/{id}/{type}', 'PurchaseOrderController@getRestock');
Route::delete('order/api/reorder/delete/{id}', 'PurchaseOrderController@deleteReorder');
Route::get('order/restock/po/{id}', 'PurchaseOrderController@getRestockFromPurchaseOrder');
Route::get('order/restock/undelivered', 'PurchaseOrderController@getRestockFromPurchaseOrder');
Route::get('order/restock/po/partDelivery', 'PurchaseOrderController@getRestockFromPurchaseOrder');
Route::get('order/restock/po/delivered/{id}', 'PurchaseOrderController@getRestockFromPurchaseOrder');
Route::post('order/restock/po', 'PurchaseOrderController@postRestockFromPurchaseOrder');
Route::get('order/print/po/{id}', 'PurchaseOrderController@printLpo');
Route::post('order/restock/status/{status}', 'PurchaseOrderController@deliveryStatus');
Route::get('order/list/deleted', 'PurchaseOrderController@getDeleted');
Route::get('order/list/restore', 'PurchaseOrderController@restore');
Route::get('order/stock/export', 'PurchaseOrderController@getReport');

