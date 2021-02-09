<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 1/7/2017
 * Time: 19:33
 */
/** Receipt Route  */

Route::resource('pos', 'ReceiptController');


/**Additional Routes**/
Route::delete('receipt/stock/delete/{id}', 'ReceiptController@destroyItem');
