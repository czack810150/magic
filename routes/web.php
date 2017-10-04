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

//Filters
Route::post('/employee/location','EmployeeController@employeesByLocation');

//Scheduled Shifts
Route::get('/shift','ShiftController@index');
Route::post('/shift/getShift', array('as'=>'ajaxdata','uses'=>'ShiftController@getShift'));


//Payroll
Route::get('/payroll','PayrollController@index');
Route::get('/payroll/basic','PayrollController@basic');
Route::post('/payroll/fetch','PayrollController@fetch');
Route::get('/payroll/{employee}/{year}','PayrollController@employeeYear');

//Sales
Route::get('/sales','SaleController@index');

//Exams
Route::get('/question_category/create','QuestionController@newCategory');
Route::post('/question_category/store','QuestionController@saveCategory');
Route::get('/question_category/{category}/delete','QuestionController@removeCategory');
Route::get('/question_category/{id}','QuestionController@showCategoryQuestions');

Route::get('/question','QuestionController@index');
Route::get('/question/{question}/show','QuestionController@show');
Route::get('/question/{question}/delete','QuestionController@destroy');
Route::get('/question/create','QuestionController@create');
Route::post('/question/create','QuestionController@store');
Route::post('/question/createShortAnswer','QuestionController@storeShortAnswer');
Route::post('/question/categoryQuestions','QuestionController@questionsByCategory');

Route::get('/exam','ExamController@index');
Route::get('/exam/all','ExamController@all');
Route::get('/exam/create','ExamController@create');
Route::post('/exam/store','ExamController@store');
Route::get('/exam/{exam}/delete','ExamController@destroy');
Route::get('/exam/{exam}/show','ExamController@show');