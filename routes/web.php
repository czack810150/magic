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
Route::get('/api/newShift',function(){
	return 'API';
});
Route::post('/api/newShift','ShiftController@apiCreate');


Route::get('/timeclock','ClockController@index')->name('timeclock')->middleware('auth');
Route::get('/timeclock/in','ClockController@in')->middleware('auth');
Route::get('/timeclock/out','ClockController@out')->middleware('auth');
Route::post('/timeclock/in','ClockController@clockIn')->middleware('auth');
Route::post('/timeclock/out','ClockController@clockOut')->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
