<?php

Auth::routes();

// TODO - Replace with post!
//Route::get('/login/{autoLoginHash}', 'Auth\LoginController@autoLogin')->name('auto-login')->where('autLoginHash', '^[A-Za-z0-9]{64}$');



// logged endpoints
Route::middleware('auth')->group(function() {

    Route::get('/home', 'HomeController@index')->name('home')->middleware('single.organization');
    Route::get('/organizations', 'OrganizationsController@index')->name('organizations');

});

