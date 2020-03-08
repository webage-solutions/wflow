<?php

Route::any('/', 'ApiController@index');

//Route::post('licenses', 'LicensesController@add');

// authentication routes
//Route::post('login', 'AuthController@login')->name('login');
//Route::post('refresh-login', 'AuthController@refreshLogin');
Route::post('logout', 'AuthController@logout')->middleware('auth:api');

// profile routes
Route::get('profile', 'ProfileController@show')->name('profile.show')->middleware('auth:api');
Route::get('profile/settings', 'ProfileController@indexSettings')->name('profile.settings')->middleware('auth:api');

// current-organization routes
Route::get('current-organization/settings', 'OrganizationsController@currentOrganizationSettings')->name('current-organization.settings')->middleware('organizationRequired');

// settings routes
Route::get('server-settings', 'ServerSettingsController@index')->name('serverSettings.index')->middleware('auth'); // TODO - Include authorization

// user routes
// TODO - Route::get('users/{user}/settings');
Route::get('users/{user}/avatar', 'UsersController@avatar')
    ->name('users.avatar')
    ->middleware(['auth:api']);

// organization routes
Route::get('organizations', 'OrganizationsController@index')
    ->name('organizations.index')
    ->middleware(['auth']);

Route::get('domains/{domain:domain}/organization', 'DomainsController@organization')
    ->name('domains.organization')
    ->where('domain', '[A-Za-z0-9-_.]{3,}');

Route::get('organizations/{organization}/logo', 'OrganizationsController@logo')
    ->name('organizations.logo');
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
