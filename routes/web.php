<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WallController@index')->name('wall');
Route::post('/', 'WallController@store');

Auth::routes();

// User profiles

Route::prefix('/user/{username}')->group(function () {
    Route::get('/', [
        'as' => 'user.profile',
        'uses' => 'UserProfileController@index'
    ]);

    Route::post('/follow', [
        'uses' => 'UserProfileController@follow'
    ])->middleware('auth');

    Route::post('/unfollow', [
        'uses' => 'UserProfileController@unfollow'
    ])->middleware('auth');
});

Route::prefix('settings')->group(function () {

    Route::get('/', [
        'as' => 'settings',
        'uses' => 'UserSettingsController@index'
    ])->middleware('auth');

    Route::post('/', [
        'as' => 'settings',
        'uses' => 'UserSettingsController@update'
    ])->middleware('auth');

    Route::get('/security', [
        'as' => 'settings.security',
        'uses' => 'UserSettingsController@security'
    ]);
  
    Route::post('/security', [
        'as' => 'settings.security',
        'uses' => 'UserSettingsController@update'
    ]);

    Route::get('/integrations', [
        'as' => 'settings.integrations',
        'uses' => 'UserSettingsController@integrations'
    ]);
});

Route::prefix('integration')->group(function () {

    Route::get('/github', 'Integration\GithubController@redirectToProvider')->middleware('auth');

    Route::get('/github/callback', [
        'as' => 'integration.github',
        'uses' => 'Integration\GithubController@handleProviderCallback'
    ])->middleware('auth');

    Route::post('/github/remove', [
        'uses' => 'Integration\GithubController@removeIntegration'
    ])->middleware('auth');
});
