<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\EmailConfirmed;
use App\User;

class EmailController extends Controller
{
    public function emailConfirm($id)
    {
        $user = User::where('email_token',$id)->first();
        if($user){
            $user->confirmed = true;
            $user->save();
            event(new EmailConfirmed($user));
            return 'Your email has been confirmed. Thank you!';
        } else {
            return 'Error 01';
        }  
    }
}
