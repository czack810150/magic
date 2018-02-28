<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
class RoleController extends Controller
{
    public function list(){
    	$roles = Role::pluck('c_name','id');
    
    	return view('layouts.magicshift.roleList',compact('roles'));
    }
}
