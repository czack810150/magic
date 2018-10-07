<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
class RoleController extends Controller
{
    public function list(Request $r){
    	$roles = Role::pluck('c_name','id');
    	if($r->defaultRole){
    		$default = $r->defaultRole;
    	} else {
    		$default = 4;
    	}
    	return view('layouts.magicshift.roleList',compact('roles','default'));
    }
}
