<?php

Route::when('profile', 'loggedIn');
Route::when('login', 'loggedOut');