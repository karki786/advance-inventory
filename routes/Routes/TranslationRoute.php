<?php

/** Category Route  */

Route::resource('translation', 'TranslationController');
Route::get('translations/items/filter', 'TranslationController@table');
Route::post('translations/item/upload', 'TranslationController@upload');
Route::get('translations/item/compile', 'TranslationController@compile');



