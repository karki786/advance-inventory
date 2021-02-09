<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 7/5/2016
 * Time: 05:54
 */
/** Currency Route  */

Route::resource('currency', 'CurrencyController');


/**Additional Routes**/
Route::get('/convert/currency', 'CurrencyController@exchangeRateConversion');
Route::get('currency/items/filter', 'CurrencyController@table');
