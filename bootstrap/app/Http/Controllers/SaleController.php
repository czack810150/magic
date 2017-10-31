<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Location;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function index()
    {
    	$locations = Location::get();
    	$now = Carbon::now();

    	//$sales = Sale::totalSales($now->toDateString(),$now->addDay()->toDateString());

    	$sales = Sale::salesBreakDown($now->toDateString(),$now->addDay()->toDateString());
    	return view('sales.index',compact('locations'));
    }
}
