<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Location;
use App\Sale;
use App\Sale_total;
use App\SaleAmount;
use App\Item;
use App\ItemCategory;
use App\SalesItemsTotal;
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

    public function twoWeekSales(Request $r){
       
        return Sale::twoWeekSales($r->location,$r->date);
    }
    public function monthlySales(Request $r){
       
        return Sale::monthlySales($r->location);
    }
    public function dashboard()
    {
        $subheader = 'Sales';

        $locations = Location::Store()->get();
        $dt = Carbon::now();
     
        $data['magicBeefs'] = Sale::whereYear('from',$dt->year)->whereMonth('from',$dt->month)->where('location_id','!=',0)->where('itemCode','S01001')->sum('qty');
        $data['monthlySales'] = Sale_total::whereYear('date',$dt->year)->whereMonth('date',$dt->month)->where('location_id',-1)->sum('total');
        $data['preMonthlySales'] = Sale_total::whereYear('date',$dt->year)->whereMonth('date',$dt->copy()->subMonth()->month)->where('location_id',-1)->sum('total');
        $data['yearSales'] = Sale_total::whereYear('date',$dt->year)->where('location_id',-1)->sum('total');
        $data['preYearSales'] = Sale_total::whereYear('date',$dt->year-1)->where('location_id',-1)->sum('total');
        if(!$data['preYearSales']) {
            $data['preYearSales'] = 1;
            $data['yearlyCompare'] = 0;
        } else {
            $data['yearlyCompare'] = $data['yearSales'] / $data['preYearSales'];
        }
      
        $items = Item::menuItems()->get();
        $categories = ItemCategory::get();
        


        return view('sales.dashboard',compact('subheader','locations','data','items','categories'));
    }
    public function monthlyByYearMonthLocation(Request $r)
    {
        return Sale::monthlySAlesByYearMonthLocation($r->year,$r->month,$r->location);
    }
    public function monthDailySales(Request $r){
       
        return SaleAmount::monthDailySales($r->location,$r->year,$r->month);
    }
    public function yearlyByLocation(Request $r){
       
        $data['yearSales'] = Sale_total::where('location_id',$r->location)->whereYear('date',$r->year)->sum('total');
        $data['preYearSales'] = Sale_total::where('location_id',$r->location)->whereYear('date',$r->year-1)->sum('total');
        if(!$data['preYearSales']) {
            $data['preYearSales'] = 1;
            $data['yearlyCompare'] = 0;
        } else {
            $data['yearlyCompare'] = $data['yearSales'] / $data['preYearSales'];
        }
        
        $data['yearSales'] = number_format($data['yearSales'],0,'.',',');
        return $data;
    }
    public function hourlySalesAmt(Request $r)
    {
        switch($r->type){
            case 'TABLE': $type = ['TABLE','UNDEFINED','FASTFOOD']; break;
            case 'TAKEOUT': $type = ['TAKEOUT']; break;
            case 'DELIVERY': $type = ['DELIVERY']; break;
            default: $type = ['TABLE','UNDEFINED','FASTFOOD'];
        }
        return SaleAmount::where('location_id',$r->location)->whereIn('tableClass',$type)->whereYear('from',$r->year)->whereMonth('from',$r->month)->get();
    }
    public function categoryBreakdown(Request $r)
    {
        return SalesItemsTotal::categoryBreakdown($r->year,$r->month,$r->location);
    }
}
