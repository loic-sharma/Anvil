<?php

Route::get('admin/navigation/menu/add', 'NavigationAdminController@getAddMenu');
Route::post('admin/navigation/menu/add', 'NavigationAdminController@postAddMenu');

Route::get('admin/navigation/menu/{slug}', 'NavigationAdminController@getMenu');

Route::get('admin/navigation/menu/{slug}/delete', 'NavigationAdminController@getDeleteMenu');

Route::get('admin/navigation/menu/{slug}/add-link', 'NavigationAdminController@getCreateLink');
Route::post('admin/navigation/menu/{slug}/add-link', 'NavigationAdminController@postCreateLink');

Route::get('admin/navigation/link/{id}/edit', 'NavigationAdminController@getEditLink');
Route::post('admin/navigation/link/{id}/edit', 'NavigationAdminController@postEditLink');

Route::get('admin/navigation/menu/{slug}/link/{id}/delete', 'NavigationAdminController@getDeleteLink');