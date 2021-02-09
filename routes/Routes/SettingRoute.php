<?php
/** Settings Route  */

Route::resource('setting', 'SettingController');


Route::post('setting/ajax/update/{id}', 'SettingController@updateAjax');
Route::get('setting/storage/folder/link', 'SettingController@createSymlink');
