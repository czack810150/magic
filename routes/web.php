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
// Route::get('/{locale}',function($locale){
// 	App::setLocale($locale);
// });


Route::get('/api/newShift',function(){
	return 'API';
});
Route::post('/api/newShift','ShiftController@apiCreate');


Route::get('/timeclock','ClockController@index')->name('timeclock')->middleware('auth');
Route::get('/timeclock/in','ClockController@in')->middleware('auth');
Route::get('/timeclock/out','ClockController@out')->middleware('auth');
Route::post('/timeclock/in','ClockController@clockIn')->middleware('auth');
Route::post('/timeclock/out','ClockController@clockOut')->middleware('auth');
Route::get('/inshift','ClockController@inShift');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



//Scheduled Shifts
Route::get('/shift','ShiftController@index');
Route::post('/shift/getShift', array('as'=>'ajaxdata','uses'=>'ShiftController@getShift'));

//Sales
Route::get('/sales','SaleController@index');
