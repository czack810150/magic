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
Route::middleware('auth')->group(function(){
	Route::get('/scheduler','ScheduleController@index');
Route::get('/scheduler/{location}/','ScheduleController@index');
Route::post('/sr/get','ShiftController@getResourcesByLocation');
Route::post('/shift/{id}/update','ShiftController@update');
Route::post('/role/get','RoleController@list');
Route::post('/datetime/parseStr','ShiftController@parseShiftTime');
Route::post('/shift/create','ShiftController@create');
Route::post('/shift/{id}/remove','ShiftController@destroy');
Route::post('/employees/positionFilter','EmployeeController@positionFilter');
Route::post('/shift/copy','ShiftController@copyShifts');
Route::post('/shift/count','ShiftController@countShifts');
Route::post('/scheduler/stats/fetch','ShiftController@fetchStats');
Route::post('/shifts/fetchWeek', 'ShiftController@fetchWeek');
Route::post('/scheduler/schedule/print','ScheduleController@print');
Route::post('/shift/getOldTotal','ShiftController@getOldTotal');
Route::post('/shift/publish','ScheduleController@publish');
});



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
Route::get('/applicant/{id}/getNote','ApplicantController@getNote');
Route::post('/employee/hireApplicant','EmployeeController@hireApplicant');
Route::post('/applicant/updateStatus','ApplicantController@update');
Route::post('/applicant/saveNote','ApplicantController@saveNote');




//file upload
Route::post('/file/employee/{id}/picture','FileUploadController@profilePictureUpload');
Route::post('/file/employee/{id}/file','FileUploadController@fileUpload');
Route::get('/storage/{id}/delete','FileUploadController@destroy');

// HR
Route::get('/hr','HrController@index');
Route::post('/hr/location/breakdown','HrController@locationBreakdown');
Route::post('/hr/employee/trace','EmployeeTraceController@trace');
Route::post('/hr/employee/trace/update','EmployeeTraceController@update');
Route::get('/team/location','HrController@team');

Route::post('/team/chart','HrController@teamChart');
//Team
Route::get('/team/taskforce','TeamController@index');
Route::get('/team/taskforce/create','TeamController@create');
Route::post('/team/taskforce/create','TeamController@store');
Route::get('/team/taskforce/{id}/view','TeamController@show');
Route::get('/team/taskforce/{id}/destroy','TeamController@destroy');
Route::post('/team/taskforce/addMember','TeamController@addMember');
Route::post('/team/taskforce/{id}/update','TeamController@update');
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

// time clock
Route::middleware('auth')->group(function(){
	Route::get('/timeclock','ClockController@index')->name('timeclock');
	Route::get('/timeclock/in','ClockController@in');
	Route::get('/timeclock/out','ClockController@out');
	Route::post('/timeclock/in','ClockController@clockIn');
	Route::post('/timeclock/out','ClockController@clockOut');
	Route::get('/timeclock/inshift','ClockController@inShift');
	Route::post('/clock/edit','ClockController@show');
	Route::post('/clock/update','ClockController@update');
	Route::post('/clock/add','ClockController@store');
	Route::post('/clock/{id}/delete','ClockController@destroy');
	
});
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');







Route::middleware('auth')->group(function(){
	// Home
	Route::get('/home', 'HomeController@index')->name('home');
	// Route::get('/home', 'MaintenanceController@index')->name('home');
	//Exams
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
// Exam Templates
Route::get('/exam_templates/','Exam_templateController@index');
Route::get('/exam_templates/{id}/show','Exam_templateController@show');
Route::get('/exam_templates/{id}/remove','Exam_templateController@destroy');
Route::post('/exam_templates/store','Exam_templateController@store');
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
Route::get('/question/fetch/{category}','QuestionController@fetch');
// test training
Route::get('/exam/learn','ExamTrainingController@index');
Route::get('/exam/learn/create','ExamTrainingController@create');
Route::post('/exam/learn/store','ExamTrainingController@store');
Route::get('/exam/learn/{id}/mock','ExamTrainingController@show');
Route::get('/exam/learn/{id}/destroy','ExamTrainingController@destroy');
Route::post('/exam/learn/{id}/update','ExamTrainingController@update');
Route::get('/exam/learn/{id}/view','ExamTrainingController@view');

	// Products
	Route::get('/products','ProductController@index')->name('products');
	Route::post('product/{id}/update','ProductController@update');
	Route::post('/product/category/get','ProductController@getProductByCategory');

	//Sales
	Route::get('/sales','SaleController@index');
	Route::post('/sales/item','SaleController@itemSales');
	Route::post('/sales/two_week','SaleController@twoWeekSales');
	Route::post('/sales/month_daily','SaleController@monthDailySales');
	Route::post('/sales/monthly','SaleController@monthlySales');
	Route::post('/sales/monthlyByYearMonthLocation','SaleController@monthlyByYearMonthLocation');
	Route::post('/sales/yearlyByLocation','SaleController@yearlyByLocation');
	Route::post('/sales/hourlySalesAmt','SaleController@hourlySalesAmt');
	Route::post('/sales/categoryBreakdown','SaleController@categoryBreakdown');


	//EMPLOYEE

Route::post('/employee/store','EmployeeController@store');
Route::post('/filter/employee/list','EmployeeController@filterEmployees');
Route::get('/employee','EmployeeController@index');
Route::get('/staff/profile/{id}/show','EmployeeController@show')->where('id','[0-9]+')->name('employee.profile');
Route::post('/employee/edit/personal','EmployeeController@editPersonal');
Route::post('/employee/edit/personal/cancel','EmployeeController@cancelPersonal');
Route::post('/employee/edit/personal/update','EmployeeController@updatePersonal');
Route::post('/employee/edit/contact','EmployeeController@editContact');
Route::post('/employee/edit/contact/cancel','EmployeeController@cancelContact');
Route::post('/employee/edit/contact/update','EmployeeController@updateContact');
Route::post('/employee/edit/address','EmployeeController@editAddress');
Route::post('/employee/edit/address/cancel','EmployeeController@cancelAddress');
Route::post('/employee/edit/address/update','EmployeeController@updateAddress');
// search
Route::post('/employee/search','EmployeeController@search');
// Legacy data
Route::get('/employee/{employee}/legacy','EmployeeController@legacy');
Route::post('/employee/legacy','EmployeeController@storeLegacy');

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

// employee profile reviews
Route::post('/employee/reviews','EmployeeReviewController@employeeReviews');


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
// Employee Stats
Route::post('/employee/stats/{id}/show','EmployeeStatsController@show');

// user employee
Route::get('/payroll/my','EmployeeUserController@payroll');
Route::get('/payroll/my/paystubs','EmployeeUserController@paystubs');
Route::post('/payroll/employee/paystub/year','EmployeeUserController@paystubsYear');
Route::post('/payroll/employee/year','EmployeeUserController@payrollYear');
Route::get('/hours/my','EmployeeUserController@hour');
Route::post('/hours/employee/year','EmployeeUserController@hourYear');
Route::get('/clocks/my','EmployeeUserController@clock');
Route::post('/clocks/employee/year','EmployeeUserController@clockYear');
Route::get('/training/my','EmployeeUserController@training');

// employee timeoff
Route::post('/employee/timeoff/{id}/show','EmployeeController@showTimeoff');

// Employee Skills
Route::get('/employee_skill','EmployeeSkillController@index');
Route::post('/employee_skill/assign','EmployeeSkillController@store');
Route::post('/employee_skill/{id}/destroy','EmployeeSkillController@destroy');
Route::post('/employee_skill/{id}/update','EmployeeSkillController@update');
Route::post('/employee_skill/get_skills','EmployeeSkillController@getSkillsByEmployee');

//employee Availability
Route::get('/employee_availability','AvailabilityController@index');
Route::post('/employee_availability/add','AvailabilityController@store');
Route::post('/employee/availability/{id}/show','AvailabilityController@employeeTab');
Route::get('/my_availability','AvailabilityController@my');

	Route::get('/sales_dashboard','SaleController@dashboard');

// Employee Metrics
	Route::get('/pendingReview','EmployeeController@pendingReview')->name('pendingReview');
// Employee Rates
	Route::post('rateSubmit','EmployeeController@rateSubmit');		
	Route::post('rateGet','EmployeeController@rateGet');
// Employee Review
Route::prefix('employeeReview')->name('employeeReview.')->group(function(){
	Route::get('/','EmployeeReviewController@index')->name('index');
	Route::get('getAllReviews','EmployeeReviewController@getAllReviews');
	Route::get('/{employee}','EmployeeReviewController@create')->name('employeeReview');
	Route::post('getPerformance','EmployeeReviewController@getPerformance');
	Route::post('submitReview','EmployeeReviewController@store');
	Route::post('verify','EmployeeReviewController@update');
	Route::get('{review}/view/{type?}','EmployeeReviewController@show');
	Route::post('updateReview','EmployeeReviewController@updateReview');
	Route::post('showPerformance','EmployeeReviewController@showPerformance');
	
});	
Route::get('self_review/{employeeReview}','EmployeeReviewController@selfReview')->name('self');	

}); // end of grouped auth

Auth::routes();
//Users
Route::get('/users','UserController@index');
Route::get('/users/new','UserController@create');
Route::post('/users/save','UserController@store');
Route::get('/email/{id}/confirm','EmailController@emailConfirm');



//Filters
Route::post('/employee/location','EmployeeController@employeesByLocation');

//Scheduled Shifts
Route::get('/shift','ShiftController@index');
Route::post('/shift/getShift', array('as'=>'ajaxdata','uses'=>'ShiftController@getShift'));


//Clocks
Route::get('/clocks','ClockController@shiftClocks');
Route::get('/clocks/view','ClockController@viewClocks');

Route::post('/clock/clocksByLocationDate','ClockController@clocksByLocationDate');
Route::post('/clocks/employeeClocksByDateRange','ClockController@employeeClocksByDateRange');
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

// Leave
Route::get('/leave','LeaveController@index');
Route::get('/request/leave','LeaveController@create');
Route::post('/request/leave/send','LeaveController@store');
Route::get('/leave/{id}/withdraw','LeaveController@destroy');
Route::get('/leave/{id}/approve','LeaveController@approve');
Route::get('/leave/{id}/deny','LeaveController@deny');
Route::get('/leave/{id}/pending','LeaveController@pending');

Route::get('/my/performanceReview','EmployeeReviewController@myReview');
// // Promotion
// Route::get('/request/promotion','PromotionController@apply');
// Route::post('/promotion/apply','PromotionController@store');
// Route::get('/promotion/view','PromotionController@index');
// Route::get('/promotion/{id}/approve','PromotionController@approve');
// Route::get('/promotion/{id}/deny','PromotionController@deny');
// Route::get('/promotion/{id}/pending','PromotionController@pending');
//

// Schedules
Route::get('/shifts/history','EmployeeUserController@scheduleHistory');
Route::post('/shifts/history','EmployeeUserController@viewScheduleHistory');

// Utilities
Route::post('/periodsByYear','UtilityController@periods');
Route::post('/employeeByLocation','UtilityController@employeeByLocation');
Route::get('/questionCategory','QuestionController@getCategory');

// Skills
Route::get('/skills','SkillController@index');
Route::get('/skills/create','SkillController@create');
Route::post('/skills/create','SkillController@store');
Route::get('/skills/{id}/delete','SkillController@destroy');
Route::get('/skills/{id}/edit','SkillController@edit');
Route::post('/skills/{id}/update','SkillController@update');


//TEST
Route::get('/test',function(){
	return 'get test ok';
});
Route::post('/test', function(){
	return 'post ok';
});