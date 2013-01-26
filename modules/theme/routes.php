<?php

Route::get('admin/themes', 'ThemeAdminController@getIndex');
Route::post('admin/themes', 'ThemeAdminController@postIndex');