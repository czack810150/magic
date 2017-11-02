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

//vue
Route::get('/vue',function(){
	return view('vue.index');
});

// end vue

//EMPLOYEE
Route::get('/employee','EmployeeController@index');

//score
Route::get('/score/category','ScoreCategoryController@index');
Route::get('/score/category/create','ScoreCategoryController@create');
Route::post('/score/category/create','ScoreCategoryController@store');
Route::get('/score/category/{id}/show','ScoreCategoryController@show');
Route::get('/score/category/{id}/delete','ScoreCategoryController@destroy');
Route::get('/score/category/{id}/edit','ScoreCategoryController@edit');
Route::post('/score/category/{id}/update','ScoreCategoryController@update');
Route::get('/score/item','ScoreItemController@index');
Route::get('/score/item/create','ScoreItemController@create');
Route::post('/score/item/store','ScoreItemController@store');
Route::get('/score/item/{id}/delete','ScoreItemController@destroy');
Route::get('/score/item/{id}/edit','ScoreItemController@edit');
Route::post('/score/item/{id}/update','ScoreItemController@update');
Route::post('/score/item/getItemsByCategory','ScoreItemController@getItemsByCategory');
// performance
Route::get('/employee/performance','EmployeePerformanceController@index');
Route::post('/employee/reviewable','EmployeePerformanceController@reviewable');
Route::post('/employee/performance/store','EmployeePerformanceController@store');



Route::get('/api/newShift',function(){
	return 'API';
});
Route::post('/api/newShift','ShiftController@apiCreate');
Route::post('/api/employee/{id}','EmployeeController@apiGet');


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

//Clocks
Route::get('/clocks','ClockController@shiftClocks');
Route::post('/clock/clocksByLocationDate','ClockController@clocksByLocationDate');
//Hours
Route::get('/hours','HourController@index');
Route::get('/hours/compute','HourController@compute');
Route::post('/hours/computeEngine','HourController@computeEngine');
Route::post('/hours','HourController@index');
Route::post('/hours/breakdown','HourController@breakdown');
//Tips
Route::get('/tips','TipController@index');
Route::get('/tips/create','TipController@create');
Route::post('/tips/store','PayrollTipController@store');
Route::get('/tips/{id}/delete','PayrollTipController@destroy');
Route::get('/tips/{id}/update','PayrollTipController@show');
Route::post('/tips/{id}/update','PayrollTipController@update');
//Payroll
Route::get('/payroll','PayrollController@index')->middleware('auth');
Route::get('/payroll/basic','PayrollController@basic');
Route::get('/payroll/compute','PayrollController@compute');
Route::post('/payroll/compute','PayrollController@computePayroll');
Route::post('/payroll/fetch','PayrollController@fetch');
Route::get('/payroll/employee/{employee}/{year}','PayrollController@employeeYear');
Route::get('/payroll/employee','PayrollController@employee');
Route::get('/payroll/{id}/destroy','PayrollController@destroy');
Route::get('/payroll/paystubs','PayrollController@paystubs');
Route::post('/payroll/paystubs','PayrollController@paystubsData');
Route::post('/payroll/chequeNumber','PayrollController@chequeNumber');
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

Route::get('/exam/{access}/take','ExamController@take');
Route::post('/exam/attempt','ExamController@attempt');
Route::post('/question/get','QuestionController@get');
Route::post('/exam/submission','ExamController@submitExam');
Route::get('/exam/attemptedExams','ExamController@attemptedExams');
Route::get('/exam/{id}/mark','ExamController@mark');