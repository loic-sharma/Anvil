<?php

Route::get('login', 'UsersController@getLogin');
Route::post('login', 'UsersController@postLogin');
Route::get('profile', 'UsersController@getProfile');
Route::get('logout', 'UsersController@getLogout');

Route::get('admin/users/create', 'UsersAdminController@getCreateUser');
Route::post('admin/users/create', 'UsersAdminController@postCreateUser');
Route::get('admin/users/{id}/edit', 'UsersAdminController@getEditUser');
Route::post('admin/users/{id}/edit', 'UsersAdminController@postEditUser');
Route::get('admin/users/{id}/delete', 'UsersAdminController@getDeleteUser');

Route::get('admin/groups', 'GroupsAdminController@getIndex');
Route::get('admin/group/create', 'GroupsAdminController@getCreate');
Route::post('admin/group/create', 'GroupsAdminController@postCreate');
Route::get('admin/group/{id}/edit', 'GroupsAdminController@getEdit');
Route::post('admin/group/{id}/edit', 'GroupsAdminController@postEdit');
Route::get('admin/group/{id}/delete', 'GroupsAdminController@getDelete');

Route::get('admin/permissions', 'PermissionAdminController@getIndex');
Route::get('admin/permission/{id}/edit', 'PermissionAdminController@getEditPermission');
Route::post('admin/permission/{id}/edit', 'PermissionAdminController@postEditPermission');