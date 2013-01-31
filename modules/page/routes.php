<?php

Route::get('page/{page}', 'PageController@page');

Route::get('admin/page/{page}/edit', 'PageAdminController@getEdit');
Route::post('admin/page/{page}/edit', 'PageAdminController@postEdit');

Route::get('admin/page/{page}/delete', 'PageAdminController@getDelete');