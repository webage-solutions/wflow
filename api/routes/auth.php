<?php

Auth::routes();

Route::get('/home', 'Auth\HomeController@index')->name('home')->middleware('auth');
