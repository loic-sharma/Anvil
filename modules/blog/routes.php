<?php

Route::get('admin/blog/post/create', 'BlogAdminController@getCreatePost');
Route::post('admin/blog/post/create', 'BlogAdminController@postCreatePost');