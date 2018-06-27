<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Location;
use App\Item;
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
    public function itemSales(Request $r)
    {
        if($r->location != -1){
            $item = Item::find($r->item);
            $sales = Sale::where('location_id',$r->location)->where('itemCode',$item->itemCode)->whereDate('from',$r->date)->orderBy('from','asc')->get();
        } else {
            $item = Item::find($r->item);
            $sales = Sale::where('itemCode',$item->itemCode)->whereDate('from',$r->date)->orderBy('from','asc')->get();
        }
    	
    	return $sales;
    }
}
