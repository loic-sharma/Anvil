<?php

Route::get('admin/users/create', 'UsersAdminController@getCreateUser');
Route::post('admin/users/create', 'UsersAdminController@postCreateUser');

Route::get('admin/users/{id}/edit', 'UsersAdminController@getEditUser');
Route::post('admin/users/{id}/edit', 'UsersAdminController@postEditUser');