<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Location;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmployeeAddedMail;
use App\Hour;

class Employee extends Model
{
    use Notifiable;
    protected $guarded = [];
    protected  $casts = [
        'other_data' => 'array'
    ];

    public function user()
    {
        return $this->hasOne('App\Authorization');
    }
    public function authorization()
    {
        return $this->hasOne('App\Authorization','employee_id');
    }
    public function rate()
    {
        return $this->hasMany(EmployeeRate::class);
    }
    public function employee_profile()
    {
        return $this->hasOne('App\Employee_profile');
    }
    public function employee_background()
    {
        return $this->hasOne('App\Employee_background');
    }
    public function employee_trace()
    {
        return $this->hasOne('App\Employee_trace');
    }

    public function getHiredAttribute($value)
    {
        if(!is_null($value))
            return Carbon::createFromFormat('Y-m-d',$value);
        else
            return null;    
    }
    public function getTerminationAttribute($value)
    {
        if(!is_null($value))
            return Carbon::createFromFormat('Y-m-d',$value);
        else
            return null;
    }
    public function clock()
    {
    	return $this->hasMany('App\Clock');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    	//return $this->belongsToMany('App\Location');
    }

     public function shift()
    {
        return $this->hasOne('App\In');
    }
   
    public function exam()
    {
        return $this->hasMany('App\Exam');
    }

    public function training()
    {
        return $this->hasMany('App\Training_log');
    }

    public function schedule(){
        return $this->hasMany('App\Shift');
    }

    public function job_location()
    {
        return $this->hasMany('App\Employee_location');
    }
    public function job()
    {
        return $this->belongsTo('App\Job');
    }
    

    public static function jobBreakdown($location)
    {
        if(is_null($location)){
            return DB::table('employees')->join('jobs','jobs.id','=','employees.job_id')->select(DB::raw('count(*) as count,jobs.rank,jobs.type'))->where('employees.status','active')->groupBy('jobs.id')->orderBy('jobs.id')->get();
        } else {
            return DB::table('employees')->join('jobs','jobs.id','=','employees.job_id')->select(DB::raw('count(*) as count,jobs.rank,jobs.type'))->where('employees.status','active')->where('location_id',$location)->groupBy('jobs.id')->orderBy('jobs.id')->get();
        }
        
    }
    public static function locationEmployeesCount(){
        $locations = Location::get();
        $result = array();
        foreach($locations as $l){
            $result[$l->name]['totalHeadCount'] = Employee::where('location_id',$l->id)->ActiveAndVacationEmployees()->count();
            $result[$l->name]['totalActive'] = $l->employee->where('status','active')->count();
            $result[$l->name]['activeRate'] = $result[$l->name]['totalActive']/$result[$l->name]['totalHeadCount'];
        }
        return $result;
    }
    public static function typesCount(){
        $locations = Location::get();
        $result = array();
        // foreach($locations as $l){
        //     $result[$l->name]['totalHeadCount'] = $l->employee->count();
        //     $result[$l->name]['totalActive'] = $l->employee->where('status','active')->count();
        //     $result[$l->name]['activeRate'] = $result[$l->name]['totalActive']/$result[$l->name]['totalHeadCount'];
        // }
        return $result;
    }
    // scopes
    public function scopeActiveEmployee($query)
    {
        return $query->where('status','active');
    }
    public function scopeTerminatedEmployees($query)
    {
        return $query->where('termination','!=',null);
    }
    public function scopeActiveAndVacationEmployees($query)
    {
        return $query->where('status','active')->orWhere('status','vacation');
    }

    public function message()
    {
        return $this->hasMany('App\Message_to');
    }

    public function availability()
    {
        return $this->hasOne('App\Availability');
    }
    public function leave()
    {
        return $this->hasMany('App\Leave');
    }
    public function approvedLeave()
    {
        return $this->hasMany('App\Leave');
    }
    public function promotion()
    {
        return $this->hasMany('App\JobPromotion');
    }
    public function skill()
    {
        return $this->hasMany('App\EmployeeSkill');
    }
    public function pending()
    {
        return $this->hasMany('App\EmployeePending');
    }
    public function file()
    {
        return $this->hasMany('App\EmployeeFile');
    }
    public function hours()
    {
        return $this->hasMany(Hour::class);
    }
    public function review()
    {
        return $this->hasMany(EmployeeReview::class);
    }
    public static function onboardCheck($employee,$date)
    {
        $employee =  self::find($employee);
        if($employee->status == 'terminated'){
            return false;
        }
        if($employee->status == 'active')
        {
            if(is_null($employee->termination)) {
                return true;
            } else  if($employee->termination->toDateString() > $date){
                return  true;
            } else {
                return false;
            }
        } 
    }
    public static function reviewPending($days,$minimumHours)
    {
        $locations = Location::store()->pluck('id');

        $employees = self::whereIn('location_id',$locations)->where('status','active')->where('termination',null)->with('job_location')->get();
        $today = Carbon::now()->startOfDay();
        $pendings = collect();
        foreach($employees as $e)
        {
            if(count($e->job_location)){ // check if the employee has been promoted before ( not new employee)
                $lastReviewDate = $e->job_location->last()->review->startOfDay();

                if( $lastReviewDate->copy()->addDays($days)->lt($today) ){
                    // $hours = $e->hours->where('start','>=',$lastReviewDate->copy()->toDateString());
                    $hours = Hour::where('employee_id',$e->id)->where('start','>=',$lastReviewDate->copy()->toDateString())
                    ->where('start','<',$lastReviewDate->copy()->addDays($days))->get();
                    $e->effectiveHours = $hours->sum('wk1Effective') + $hours->sum('wk2Effective') + $hours->sum('wk1EffectiveCash') + $hours->sum('wk2EffectiveCash');
                    $e->effectiveHours >= $minimumHours? $e->reviewable = true:$e->reviewable = false;
                    $e->notified = $e->job_location->last()->notified;
                    $pendings->push($e);
                }
                
            } else {  // check if new employees are due for reivew
                if( $e->hired->startOfDay()->copy()->addDays($days)->lt($today) ){
                    $hours = $e->hours->where('start','>=',$e->hired->copy()->toDateString());
                    $e->effectiveHours = $hours->sum('wk1Effective') + $hours->sum('wk2Effective') + $hours->sum('wk1EffectiveCash') + $hours->sum('wk2EffectiveCash');
                    $e->effectiveHours >= $minimumHours? $e->reviewable = true:$e->reviewable = false;
                    $e->notified = 0;
                    $pendings->push($e);
                }
            }
        }
        return $pendings;
    }
    public function reviewable()
    {
        if($this->status != 'terminated')
        {   
            $days = 180;
            $minimumReviewHour = 420;
            $today = Carbon::now()->startOfDay();
            if(count($this->job_location)){ // check if the employee has been promoted before ( not new employee)
                $lastReviewDate = $this->job_location->last()->review->startOfDay();
                if( $lastReviewDate->copy()->addDays($days)->lt($today) ){
                    $hours = Hour::where('employee_id',$this->id)->where('start','>=',$lastReviewDate->copy()->toDateString())
                    ->where('start','<',$lastReviewDate->copy()->addDays($days))->get();
                    $this->effectiveHours = $hours->sum('wk1Effective') + $hours->sum('wk2Effective') + $hours->sum('wk1EffectiveCash') + $hours->sum('wk2EffectiveCash');
                   if( $this->effectiveHours >= $minimumReviewHour ) {
                    return ['result' => true,
                    ]; 
                    } else {

                    return ['result' => false,
                        'reason' => "Hours less than $minimumReviewHour"
                     ];
                    }
                } else {
                    return ['result' => false,
                        'reason' => "Last review date less than $days days from today"
                     ];
                }
            } else {
                if( $this->hired->startOfDay()->copy()->addDays($days)->lt($today) ){
                    $hours = $this->hours->where('start','>=',$this->hired->copy()->toDateString());
                    $this->effectiveHours = $hours->sum('wk1Effective') + $hours->sum('wk2Effective') + $hours->sum('wk1EffectiveCash') + $hours->sum('wk2EffectiveCash');
                    if($this->effectiveHours >= $minimumReviewHour)
                    {
                        return ['result' => true];
                    } else {
                        return false;
                    }
                } else {
                    return ['result' => false,
                        'reason' => "Hire date less than $days days from today"
                     ];
                }
            }
        } else {
            return ['result' => false,
                    'reason' => 'Terminated Employee'
            ];
        } 
    }
    public function getEffectiveHoursAttribute()
    {
        $hours =  $this->hours;
        $effective =  $hours->sum('wk1Effective') + $hours->sum('wk2Effective') + $hours->sum('wk1EffectiveCash') + $hours->sum('wk2EffectiveCash');
        return $effective;

    }

    public static function activeTrialEmployee($location_id)
    {
        return self::where('job_group','trial')->where('location_id',$location_id)->where('status','active')->get();
    }

    public function getCurrentReviewAttribute(){
        return $this->review->where('reviewDate','<=',Carbon::now()->toDateString())->where('nextReview','>',Carbon::now()->toDateString())->first();
    }
}
