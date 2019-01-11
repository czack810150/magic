<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class HighManagement
{
    public function handle($request, Closure $next)
    {
        if(Auth::user()->authorization->level < 30){

            session()->flash('status','Access Restricted');
            return redirect('home');
        }
        return $next($request);
    }
}
