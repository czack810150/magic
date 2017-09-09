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

Route::get('/timeclock','ClockController@index')->name('timeclock');
Route::get('/timeclock/in','ClockController@in');
Route::get('/timeclock/out','ClockController@out');
Route::post('/timeclock/in','ClockController@clockIn');
Route::post('/timeclock/out','ClockController@clockOut');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
