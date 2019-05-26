<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('v1/login', 'Api\v1\UserController@authenticate');

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1', 'middleware' => ['jwt.verify']], function() {
    Route::get('/languages', 'LanguageController@index')->name('languages.index');
    Route::group(['prefix' => 'courses'], function() {
        Route::get('/', 'CourseController@index')->name('courses.index');
        Route::get('levels', 'CourseController@getLevels')->name('courses.getLevels');
    });
    Route::group(['prefix' => 'units'], function() {
        Route::get('/search', 'UnitController@index')->name('units.index');
    });
});