<?php

Route::get('admin/templates', 'TemplateAdminController@getIndex');
Route::post('admin/templates', 'TemplateAdminController@postIndex');