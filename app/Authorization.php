<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Authorization extends Model
{
    protected $fillable = ['user_id','employee_id','type','location_id','level'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function location()
    {
    	return $this->belongsTo('App\Location');
    }
    public static function group(Array $group)
    {
        $staffs = new Collection;
        $auths = self::whereIn('type',$group)->get();
        foreach($auths as $a)
        {
            $staffs->push($a->employee);
        }
        return $staffs;
    }
}
