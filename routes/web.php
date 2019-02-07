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

Route::get('/', function () {
    return view('welcome');
});

// middlewareが必要な場合
Route::group(['middleware' => []], function()
{
    
});

Auth::routes();
//getでもログアウト
$this->get('logout', 'Auth\LoginController@logout')->name('logout');


Route::group(['middleware' => ['boot', 'down']], function()
{
    //Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');


    // 管理者管理
    Route::group(['prefix' => 'user'], function()
    {
        Route::get('/', 'Admin\UserController@lists');
        Route::get('/display/{count}', 'Admin\UserController@display');
        Route::get('/create', 'Admin\UserController@create');
        Route::post('/create', 'Admin\UserController@create_post');
        Route::get('/update/{id}', 'Admin\UserController@update');
        Route::put('/update/{id}', 'Admin\UserController@update_post');
        Route::get('/delete/{id}', 'Admin\UserController@delete');
        Route::delete('/delete/{id}', 'Admin\UserController@delete_post');
    });
    Route::group(['prefix' => 'auth'], function()
    {
    });


});

Route::get('/test/gads', 'Google\GoogleTestController@index');
