<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 7/4/2016
 * Time: 20:02
 */
Route::resource('company', 'CompanyController');
Route::post('/company/upload/photo/{id}', 'CompanyController@uploadLogo');
Route::post('/company/upload/favicon/{id}', 'CompanyController@uploadFavicon');
Route::get('logo/{filename}', 'CompanyController@getLogo');



