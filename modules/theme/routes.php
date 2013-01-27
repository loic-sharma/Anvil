<?php

Route::get('admin/themes', 'ThemeAdminController@getIndex');
Route::post('admin/themes', 'ThemeAdminController@postIndex');

Route::get('admin/theme/{theme}/preview', 'ThemeAdminController@getPreview');
Route::get('admin/theme/{theme}/delete', 'ThemeAdminController@getDelete');