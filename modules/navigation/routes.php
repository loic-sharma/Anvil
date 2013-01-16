<?php

Route::get('admin/navigation/menu/{slug}/edit', 'NavigationAdminController@getMenu');

Route::get('admin/navigation/menu/{slug}/add-link', 'NavigationAdminController@getCreateLink');
Route::post('admin/navigation/menu/{slug}/add-link', 'NavigationAdminController@postCreateLink');

Route::get('admin/navigation/link/{id}/edit', 'NavigationAdminController@getEditLink');
Route::post('admin/navigation/link/{id}/edit', 'NavigationAdminController@postEditLink');