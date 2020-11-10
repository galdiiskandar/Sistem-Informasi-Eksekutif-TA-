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
    return view('auth.login');
});

Route::get('/test', 'MaintenanceCostController@test');

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    
    Route::get('/dashboard', 'MaintenanceCostController@dashboard');

    Route::get('/user', 'UserController@index');
    Route::post('/user/store', 'UserController@store');
    Route::post('/user/update', 'UserController@update');
    Route::get('/user/destroy/{id}', 'UserController@destroy');
    Route::get('/user/profile', 'UserController@userProfile');
    Route::post('/user/update/password', 'UserController@changePassword');
    Route::post('/user/update/profile', 'UserController@updateProfile');
    
    Route::get('/room', 'RoomController@index');
    Route::post('/room/store', 'RoomController@store');
    Route::post('/room/update', 'RoomController@update');
    Route::get('/room/destroy/{id}', 'RoomController@destroy');

    Route::get('/product', 'ProductController@index');
    Route::post('/product/store', 'ProductController@store');
    Route::post('/product/update', 'ProductController@update');
    Route::get('/product/destroy/{id}', 'ProductController@destroy');

    Route::get('/room-inventory', 'RoomInventoryController@index');
    Route::post('/room-inventory/store', 'RoomInventoryController@store');
    Route::post('/room-inventory/update', 'RoomInventoryController@update');
    Route::get('/room-inventory/destroy/{id}', 'RoomInventoryController@destroy');
    Route::get('/room-inventory/report', 'RoomInventoryController@report');
    Route::post('/room-inventory/print', 'RoomInventoryController@report');
    
    Route::get('/maintenance-cost', 'MaintenanceCostController@index');
    Route::post('/maintenance-cost/store', 'MaintenanceCostController@store');
    Route::post('/maintenance-cost/update', 'MaintenanceCostController@update');
    Route::get('/maintenance-cost/destroy/{id}', 'MaintenanceCostController@destroy');
    Route::post('/maintenance-cost/print', 'MaintenanceCostController@report');

    Route::get('/bendungan', 'BendunganController@index');
    Route::post('/bendungan/store', 'BendunganController@store');
    Route::get('/bendungan/destroy/{id}', 'BendunganController@destroy');
    Route::post('/bendungan/update', 'BendunganController@update');
});