<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\UrlGenerator;
use App\Employee_profile;
use App\EmployeeFile;


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
    public function fileUpload($id, Request $r)
    {
        if(Gate::allows('update-profile-picture',$id)){
            if($r->hasFile('file'))
        {
            if($r->file('file')->isValid())
            {
                
                $path = Storage::disk('public')->put('file/employee',$r->file('file'));
                
                $status = EmployeeFile::create([
                    'employee_id' => $id,
                    'type' => $r->file_type,
                    'path' => $path,
                    'name' => $r->file->getClientOriginalName()
                ]);
                if($status)
                {
                    return redirect(url()->previous())->with('status','Employee file upload.')->with('statusCode',1);
                } else {
                    return redirect(url()->previous())->with('status','Employee file upload failed.')->with('statusCode',0);
                }
            } else {
                return 'file is not valid';
            }
        } else {
            return 'no file';
        }
        } else {
            return 'You are not authorized to upload any files.';
        }
    }
    public function destroy($id)
    {
        $file = EmployeeFile::findOrFail($id);
        $status = Storage::disk('public')->delete($file->path);
        if($status)
                {
                    $file->delete();
                    return redirect(url()->previous())->with('status','Employee file deleted.')->with('statusCode',1);
                } else {
                    return redirect(url()->previous())->with('status','Employee file delete failed.')->with('statusCode',0);
                }
    }
}
