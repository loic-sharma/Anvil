<?php

Route::get('admin/navigation/menu/{slug}/edit', 'NavigationAdminController@getMenu');

Route::get('admin/navigation/menu/{slug}/add-link', 'NavigationAdminController@getCreateLink');
Route::post('admin/navigation/menu/{slug}/add-link', 'NavigationAdminController@postCreateLink');