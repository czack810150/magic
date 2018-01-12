<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee_profile;

class FileUploadController extends Controller
{
    public function upload($id,Request $r)
    {
    	if($r->hasFile('file'))
    	{
    		if($r->file('file')->isValid())
    		{
    			$employee_profile = Employee_profile::where('employee_id',$id)->first();
    			$path = $r->file->store('employee');
    			$employee_profile->img = $path;
    			$employee_profile->save();
    			return $path;
    		} else {
    			return 'file is not valid';
    		}
    	} else {
    		return 'no file';
    	}
    }
}
