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

// Admin Auth
Route::group([
    'prefix' => '/admin',
    'namespace' => 'Admin',
    'middleware' => ['auth:admin', 'admin.active']
], function () {

    Route::group([
       'middleware' => ['admin.supper']
    ], function () {
        Route::get('/admins', 'AdminController@index');
        Route::post('/admins', 'AdminController@store');
        Route::get('/admins/{admin}', 'AdminController@info');
        Route::delete('/admins/{admin}', 'AdminController@destory');

        Route::get('/permissions/options', 'PermissionController@options');
        Route::get('/permissions', 'PermissionController@index');
        Route::post('/permissions', 'PermissionController@store');
        Route::post('/permissions/refresh', 'PermissionController@refresh');

        Route::get('/roles/options', 'RoleController@options');
        Route::get('/roles/menu/options', 'RoleController@menuOptions');
        Route::get('/roles', 'RoleController@index');
        Route::post('/roles', 'RoleController@store');
        Route::get('/roles/{role}', 'RoleController@info');
        Route::delete('/roles/{role}', 'RoleController@destory');
    });

    Route::post('/me/password', 'MeController@resetPassword');

    Route::get('/users', 'UserController@index')->permission('user.list');
    Route::get('/users/export', 'UserController@export')->permission('user.export');
    Route::get('/users/{user}', 'UserController@info')->permission('user.info');

    Route::post('/files/article', 'FileController@article');
    Route::post('/files/135editor/{id}', 'FileController@_135editor');

    Route::get('/articles', 'ArticleController@index')->permission('article.list');
    Route::post('/articles', 'ArticleController@store')->permission('article.edit');
    Route::get('/articles/{article}', 'ArticleController@info')->permission('article.info');
    Route::delete('/articles/{article}', 'ArticleController@destroy')->permission('article.delete');

});

// Admin
Route::group([
    'prefix' => '/admin',
    'namespace' => 'Admin',
], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/check', 'AuthController@check');
});