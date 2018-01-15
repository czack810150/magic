<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\UrlGenerator;
use App\Employee_profile;


class FileUploadController extends Controller
{
    public function profilePictureUpload($id,Request $r)
    {
    	if(Gate::allows('update-profile-picture',$id)){
    		if($r->hasFile('file'))
    	{
    		if($r->file('file')->isValid())
    		{
    			$employee_profile = Employee_profile::where('employee_id',$id)->first();
    			//$path = $r->file->store('public/image/employee');
    			$path = Storage::disk('public')->put('image/employee',$r->file('file'));
    			$employee_profile->img = $path;
    			$status = $employee_profile->save();
    			if($status)
    			{
    				return redirect(url()->previous())->with('status','Profile picture updated.')->with('statusCode',1);
    			} else {
    				return redirect(url()->previous())->with('status','Profile picture update failed.')->with('statusCode',0);
    			}
    		} else {
    			return 'file is not valid';
    		}
    	} else {
    		return 'no file';
    	}
    	}
    	
    }
}
