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

Route::get('/scheduler','ScheduleController@index');



Route::get('/qr',function(){
	return  QRCode::text('Laravel QR Code Generator!')->svg();    
});

//vue
Route::get('/vue',function(){
	return view('vue.index');
});

//Log out
Route::get('/logout',function(){
	auth()->logout();
	return redirect('/');
});

// end vue
// APPLICANTS
Route::get('/applicant','ApplicantController@index');
Route::get('/applicant/{id}/view','ApplicantController@show');
Route::get('/applicant/{id}/remove','ApplicantController@destroy');
Route::post('/applicant/{id}/get','ApplicantController@fetch');
Route::post('/employee/hireApplicant','EmployeeController@hireApplicant');
Route::post('/applicant/updateStatus','ApplicantController@update');


//EMPLOYEE
Route::post('/employee/store','EmployeeController@store');
Route::post('/filter/employee/list','EmployeeController@filterEmployees');
Route::get('/employee','EmployeeController@index');
Route::get('/staff/profile/{id}/show','EmployeeController@show')->where('id','[0-9]+');
Route::post('/employee/edit/personal','EmployeeController@editPersonal');
Route::post('/employee/edit/personal/cancel','EmployeeController@cancelPersonal');
Route::post('/employee/edit/personal/update','EmployeeController@updatePersonal');
Route::post('/employee/edit/contact','EmployeeController@editContact');
Route::post('/employee/edit/contact/cancel','EmployeeController@cancelContact');
Route::post('/employee/edit/contact/update','EmployeeController@updateContact');
Route::post('/employee/edit/address','EmployeeController@editAddress');
Route::post('/employee/edit/address/cancel','EmployeeController@cancelAddress');
Route::post('/employee/edit/address/update','EmployeeController@updateAddress');
// Employee background
Route::post('/employee/background/{id}/show','EmployeeController@background');
Route::post('/employee/education/{id}/edit','EmployeeController@editEducation');
Route::post('/employee/education/{id}/update','EmployeeController@updateEducation');
Route::post('/employee/workhistory/{id}/edit','EmployeeController@editWorkHistory');
Route::post('/employee/workhistory/{id}/update','EmployeeController@updateWorkHistory');
//employement tab
Route::post('/employee/employment','EmployeeController@employment');
Route::post('/employee/employment/edit','EmployeeController@editEmployment');
Route::post('/employee/employment/update','EmployeeController@updateEmployment');
// employee note
Route::post('/employee/note','EmployeeNoteController@index');
Route::post('/employee/note/save','EmployeeNoteController@store');
Route::post('/employee/note/{id}/edit','EmployeeNoteController@edit');
Route::post('/employee/note/{id}/update','EmployeeNoteController@update');
Route::post('/employee/note/{id}/delete','EmployeeNoteController@destroy');

// performance
Route::get('/employee/performance','EmployeePerformanceController@index');
Route::post('/employee/reviewable','EmployeePerformanceController@reviewable');
Route::post('/employee/performance/store','EmployeePerformanceController@store');
Route::post('/score/view/employeePeriod','EmployeePerformanceController@employeePeriod');
Route::post('/score/remove','EmployeePerformanceController@destroy');
Route::post('/employee/performance','EmployeePerformanceController@employee');

// compensation
Route::post('/employee/compensation','EmployeeController@compensation');
// Account
Route::post('/employee/account','EmployeeController@account');
Route::post('/employee/account/{id}/edit','EmployeeController@editAccount');
Route::post('/employee/account/{id}/update','EmployeeController@updateAccount');
// Employee Trainning
Route::post('/employee/training','EmployeeController@training');
Route::post('/skill/category/{id}/get','SkillController@getSkillByCategory');
Route::post('/skill/assign','SkillController@assignSkill');


// user employee
Route::get('/payroll/my','EmployeeUserController@payroll');
Route::post('/payroll/employee/year','EmployeeUserController@payrollYear');
Route::get('/hours/my','EmployeeUserController@hour');
Route::post('/hours/employee/year','EmployeeUserController@hourYear');
Route::get('/clocks/my','EmployeeUserController@clock');
Route::post('/clocks/employee/year','EmployeeUserController@clockYear');
Route::get('/training/my','EmployeeUserController@training');
//file upload
Route::post('/file/employee/{id}/picture','FileUploadController@profilePictureUpload');

// HR
Route::get('/hr','HrController@index');
Route::post('/hr/employee/trace','EmployeeTraceController@trace');
Route::post('/hr/employee/trace/update','EmployeeTraceController@update');

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
Route::get('/api/newShift',function(){
	return 'API';
});
Route::post('/api/newShift','ShiftController@apiCreate');
Route::post('/api/employee/{id}','EmployeeController@apiGet');
Route::post('/api/employeeBylocation','EmployeeController@location');


Route::get('/timeclock','ClockController@index')->name('timeclock')->middleware('auth');
Route::get('/timeclock/in','ClockController@in')->middleware('auth');
Route::get('/timeclock/out','ClockController@out')->middleware('auth');
Route::post('/timeclock/in','ClockController@clockIn')->middleware('auth');
Route::post('/timeclock/out','ClockController@clockOut')->middleware('auth');
Route::get('/timeclock/inshift','ClockController@inShift');
Route::post('/clock/edit','ClockController@show');
Route::post('/clock/update','ClockController@update');
Route::post('/clock/add','ClockController@store');
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();
//Users
Route::get('/users','UserController@index');
Route::get('/users/new','UserController@create');
Route::post('/users/save','UserController@store');

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
Route::get('/payroll','PayrollController@index');
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
Route::get('/question/{question}/edit','QuestionController@edit');
Route::post('/question/{question}/update','QuestionController@update');
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
Route::get('/my_exam','ExamController@my');

//Jobs
Route::get('/jobs','JobController@index');
// My voice
Route::get('/message/management','MessageToManagementController@create');
Route::post('/message/management/send','MessageToManagementController@store');
Route::get('/message/management/sent','MessageToManagementController@sent')->name('messageSuccess');
Route::get('/message/management/inbox','MessageToManagementController@inbox')->name('inbox');
Route::post('/message/management/message/{message}/show','MessageToManagementController@showMessage');
Route::post('/message/management/message/{message_to}/read','MessageToManagementController@markRead');
// Integration
Route::get('/integration/importClocks','IntegrationController@importClocks');
Route::get('/integration/shiftAutoPull','IntegrationController@shiftAutoPull');
// Scripts
Route::get('/api/fixShared','ScriptController@fixShared');
// Managers
Route::get('/manager/attendance','ManagerController@attendance');
Route::post('/manager/attendance','ManagerController@attendanceByDateRange');
Route::post('/manager/attendance/detail','ManagerController@attendanceDetail');
// Store Reports
Route::get('/store/report/performance','EmployeePerformanceController@overview');
Route::post('/store/report/performance','EmployeePerformanceController@getStorePerformance');
Route::get('/store/report/schedule','HourController@scheduledHourReport');
Route::post('/store/report/schedule','HourController@scheduledHourReportData');