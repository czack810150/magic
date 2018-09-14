<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Employee;
use App\Location;

class EmployeeRate extends Model
{
    protected $fillable = ['employee_id','type','cheque','rate','variableRate','extraRate','start','end'];
    public function employee()
    {
    	return $this->belongsTo(Employee::class);
    }



    public static function syncRates()
    {
    	$stores = Location::store()->with('employee.job_location.job')->get();
    	$result = collect();
    	foreach($stores as $s)
    	{
    		foreach($s->employee as $e)
    		{
    			foreach($e->job_location as $j)
    			{
    				$result->push(['store'=>$s->name,'employee_id'=>$e->id,'name'=>$e->name,'job' => $j->job->rank,'rate' => $j->job->rate+1400,
    					'start' => $j->start,
    					'end' => $j->end,
    			]);
    			}
    			
    		}
    		
    	}
    	$count = 0;
    	foreach($result as $r)
    	{
    		self::create([
    			'employee_id' => $r['employee_id'],
    			'type' => 'hour',
    			'cheque' => true,
    			'rate' => $r['rate'],
    			'start' => $r['start'],
    			'end' => $r['end'],
    			]);
    		$count += 1;
    	}
    	return $count;
    }
}
