<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 10/22/2016
 * Time: 18:01
 */

Route::get('notification/read/{id}', 'NotificationsController@markAsRead');
Route::get('notifications/read', 'NotificationsController@markAllAsRead');
Route::get('notification/redirect/{id}', 'NotificationsController@redirectToUrl');