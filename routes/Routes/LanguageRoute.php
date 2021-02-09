<?php

/** Category Route  */

Route::resource('language', 'LanguageController');
Route::get('language/items/filter', 'LanguageController@table');


