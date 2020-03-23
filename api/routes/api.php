<?php

Route::any('/', 'ApiController@index');

//Route::post('licenses', 'LicensesController@add');

// open routes
// organizations logo route
Route::get('organizations/{organization}/logo', 'OrganizationsController@logo')->name('organizations.logo');

// authenticated routes
Route::middleware('auth:api')->group(function() {

    // auth routes
    Route::post('logout', 'AuthController@logout');

    // profile routes - for the logged user
    Route::get('profile', 'ProfileController@show')->name('profile.show');
    Route::get('profile/settings', 'ProfileController@indexSettings')->name('profile.settings');
    Route::get('profile/auto-login-hash', 'ProfileController@generateAutoLogin')->name('profile.aut-login-hash');

    // user routes - for other users
    // TODO - Route::get('users/{user}/settings');
    Route::get('users/{user}/avatar', 'UsersController@avatar')->name('users.avatar');

    // organizations routes

});




// current-organization routes
Route::get('current-organization/settings', 'OrganizationsController@currentOrganizationSettings')->name('current-organization.settings')->middleware('organizationRequired');

// settings routes
Route::get('server-settings', 'ServerSettingsController@index')->name('serverSettings.index')->middleware('auth'); // TODO - Include authorization

// organization routes
Route::get('organizations', 'OrganizationsController@index')
    ->name('organizations.index')
    ->middleware(['auth:api']);

Route::get('domains/{domain:domain}/organization', 'DomainsController@organization')
    ->name('domains.organization')
    ->where('domain', '[A-Za-z0-9-_.]{3,}');


// TODO- Route::get('organizations/{organization}/settings');

// task types routes
Route::get('task-types', 'TaskTypesController@index')
    ->name('task-types.index')
    ->middleware(['auth']);
Route::get('task-types/{taskType}', 'TaskTypesController@view')
    ->name('task-types.view')
    ->middleware(['auth']);

// tasks routes
Route::get('tasks/{task}', 'TasksController@view')
    ->name('tasks.view')
    ->middleware('auth');
Route::put('tasks/{task}/{transition}', 'TasksController@executeTransition')
    ->name('tasks.executeTransition')
    ->middleware('auth')
    ->where('transition', '^[a-z0-9\-]+$');


Route::post('licenses', 'LicensesController@add');



//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
