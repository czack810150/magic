<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Location;
use App\Sale_total;
use App\Item;
use App\SalesItemsTotal;

class Sale extends Model
{
	protected $fillable = ['location_id','itemCode','item_category_id','name','qty','amount','from','to'];
    public function item()
    {
        return $this->belongsTo('App\Item','itemCode','itemCode');
    }

    public static function totalSales($start,$end)
    {
    	$result = self::sales($start,$end);
		$salesTotal = 0;
		foreach($result as $r){
			if(isset($r->AmtSold) && $r->Location != 'Main' && $r->ItemCode != 'ZZ9900')
			$salesTotal += $r->AmtSold;
		}
		return round($salesTotal,2);
    }

    public static function getStoreSales($start,$end)
    {
    	$result = self::sales($start,$end);
		$storeSales = array();

		foreach($result as $r){
			if(isset($r->AmtSold) && $r->Location != 'Main')
				if(!isset($storeSales[$r->Location])){
					$storeSales[$r->Location] = $r->AmtSold;
				} else {
					$storeSales[$r->Location] += $r->AmtSold;
				}		
		}
		return $storeSales;
    }

	private static function getSales($from,$to)
    {
    	$client = new Client();
    	$link = 'http://magicnoodlehq.dd.mrsdigi.com/DigiAct.php/ajax/ItemSalesSummary';
    	$headers = [
    		'Content-Type' => 'application/json'
    	];
    	$body = [
    	 "user" => "Dashboard", 
    	 "pswd" => "cXZ278c95j9c8gU",  
    	 "DateTimeFrom" => $from, 
    	 "DateTimeTo"=> $to 
    	];
    	return $client->request('POST',$link,['headers' => $headers, 'body' => json_encode($body)]);

    }

    public static function sales($from,$to)
    {
    	$res = self::getSales($from,$to);
    	if($res->getStatusCode() == '200'){
    		// if(isset(json_decode($res->getBody())->error)){
    			return json_decode($res->getBody());
    		// } else {
    			// $sales = json_decode($res->getBody());
    			// return $sales;
    		// } 
    		
    	} else {
    		return false;
    	}
    }

    public static function saveSales($from,$to)
    {
    	$sales = self::sales($from,$to);
    	if(!isset($sales->result) && !isset($sales['result']))
    	{
    		$count = 0;
    		foreach($sales as $s)
    		{
                if(isset($s->ItemCode) && $s->ItemCode != 'ZZ9900'){


    			switch($s->Location){
    				case 'Store1':
    					$location = 1; break;
    				case 'Store2':
    					$location = 2; break;
    				case 'Store3':
    					$location = 3; break;
    				case 'Store4':
    					$location = 4; break;
    				case 'Main': 
    					$location = 0; break;
    				default:
    					$location = 9;
    			}
                $item = Item::where('itemCode',$s->ItemCode)->first();
                if($item){
                    $category = $item->item_category_id;
                } else {
                    $category = null;
                }

    			 $data = self::create([
                    'location_id' => $location,
                    'item_category_id' => $category,
                    'itemCode' => $s->ItemCode,
                    'name' => $s->ItemDesc,
                    'qty' => $s->QtySold,
                    'amount' => $s->AmtSold,
                    'from' => $from,
                    'to' => $to,
                ]);

    			$count++;	
                }
    		}
    		return $count;
    	} else {
    		return ['result' => false, 'error' => 'API error'];
    	}
    }
    public static function daySales($date,$interval)
    {
    	$dt = Carbon::createFromFormat('Y-m-d',$date)->startOfDay();
    	$count = 0;
    	while($dt->toDateString() == $date){
    		$result = self::saveSales($dt->toDateTimeString(),$dt->addMinutes($interval)->toDateTimeString());
    		if(!isset($result['result'])){
    			$count += $result;
    		}
    	}
    	return $count;
    }
    // sale daliy items count
    public static function dayItemQty($date){
        $dt = Carbon::createFromFormat('Y-m-d',$date)->startOfDay();
        $sales = self::sales($dt->toDateString(),$dt->addDay()->toDateString());
        if(!isset($sales->result) && !isset($sales['result']))
        {
            $count = 0;
            foreach($sales as $s)
            {
                if(isset($s->ItemCode) && $s->ItemCode != 'ZZ9900'){


                switch($s->Location){
                    case 'Store1':
                        $location = 1; break;
                    case 'Store2':
                        $location = 2; break;
                    case 'Store3':
                        $location = 3; break;
                    case 'Store4':
                        $location = 4; break;
                    case 'Main': 
                        $location = 0; break;
                    default:
                        $location = 9;
                }
                $item = Item::where('itemCode',$s->ItemCode)->first();
                if($item){
                    $category = $item->item_category_id;
                } else {
                    $category = null;
                }
                $data = SalesItemsTotal::create([
                    'location_id' => $location,
                    'item_category_id' => $category,
                    'itemCode' => $s->ItemCode,
                    'name' => $s->ItemDesc,
                    'qty' => $s->QtySold,
                    'amount' => $s->AmtSold,
                    'date' => $date,
                ]);

                $count++;   
                }
            }
            return $count;
        } else {
            return ['result' => false, 'error' => 'API error'];
        }
    }


    public static function importSales($fromDate,$toDate,$interval)
    {
    	$from = Carbon::createFromFormat('Y-m-d',$fromDate)->startOfDay();
    	$to = Carbon::createFromFormat('Y-m-d',$toDate)->startOfDay();
    	$count = 0;
    	while($from->toDateString() != $to->toDateString())
    	{
    		
    		$count += self::daySales($from->toDateString(),$interval);
    		$from->addDay();
    	}
    	return $count;
    }

    public function location()
    {
    	return $this->belongsTo('App\Location');
    }

    public static function twoWeekSales($location,$date){

            $dt = Carbon::createFromFormat('Y-m-d',$date)->startOfDay()->subDays(14);
            $sales = collect();
            $result = collect();
            $labels = collect();
            $values = collect();
            if($location == -1){
                while($dt->toDateString() <= $date){
                $sale = Sale_total::where('location_id',-1)->where('date',$dt->toDateString())->first();
                if($sale){
                    $data = [
                    'date' => $dt->toDateString(),
                    'amount' => round($sale->total,2),
                ];
                $labels->push($dt->toDateString());
                $values->push(round($sale->total,2));
                $sales->push($data);
                
                }
                $dt->addDay();
                }
                
            } else {
                while($dt->toDateString() <= $date){
                $sale = Sale_total::where('location_id',$location)->where('date',$dt->toDateString())->first();
                if($sale){
                    $data = [
                    'date' => $dt->toDateString(),
                    'amount' => round($sale->total,2),
                ];
                $labels->push($dt->toDateString());
                $values->push(round($sale->total,2));
                $sales->push($data);
                }
                $dt->addDay();
                }
            }
            
            $result->put('sales',$sales);
            $result->put('labels',$labels);
            $result->put('totals',$values);
        return $result;
    }
    public static function monthlySales($location){
        $dt = Carbon::now();
        
        $sales = Sale_total::where('location_id',$location)->whereYear('date',$dt->year)->whereMonth('date',$dt->month)->sum('total');
        $data['thisMonth'] = number_format($sales,0,'.',',');
        $previousMonth = Sale_total::where('location_id',$location)->whereYear('date',$dt->year)->whereMonth('date',$dt->subMonth()->month)->sum('total');
        $data['lastMonth'] = number_format($previousMonth,0,'.',',');
        $data['monthCompare'] = round($sales / $previousMonth*100,2);
        return $data;
    }
    public static function monthlySalesByYearMonthLocation($year,$month,$location)
    {
        $dt = Carbon::createFromDate($year,$month,1);
        $sales = Sale_total::where('location_id',$location)->whereYear('date',$year)->whereMonth('date',$month)->sum('total');
        $data['selectedMonth'] = number_format($sales,0,'.',',');
        $previousMonth = Sale_total::where('location_id',$location)->whereYear('date',$dt->year)->whereMonth('date',$dt->subMonth()->month)->sum('total');
        $data['prevMonth'] = number_format($previousMonth,0,'.',',');
        if($data['prevMonth']){
            $data['monthCompare'] = round($sales / $previousMonth*100,2);
        } else {
            $data['monthCompare'] = 0;
        }
        
        return $data;

    }
    public static function saveDailySales($date)
    {
        $locations = Location::Store()->get();
        $dt = Carbon::createFromFormat('Y-m-d',$date)->startOfDay();
        $sale = Sale::whereDate('from',$dt->toDateString())->where('amount','>',0)->sum('amount');
        Sale_total::create([
            'location_id' => -1,
            'date' => $date,
            'total' => round($sale,2)
        ]);
        foreach($locations as $location)
        {
            $sale = Sale::where('location_id',$location->id)->whereDate('from',$dt->toDateString())->where('amount','>',0)->sum('amount');
            Sale_total::create([
            'location_id' => $location->id,
            'date' => $date,
            'total' => round($sale,2)
            ]);
        }
        return true;
    }
    public static function saveMonthlySales($year,$month)
    {
        $dt = Carbon::createFromDate($year,$month,1)->StartOfDay();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
        $count = 0;
        while($endOfMonth != $dt->toDateString())
        {
            self::saveDailySales($dt->toDateString());
            $dt->addDay();
            $count++;
        }
        return $count;
    }
    public static function saveMonthlyItemsSales($year,$month)
    {
        $dt = Carbon::createFromDate($year,$month,1)->StartOfDay();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
        $count = 0;
        while($endOfMonth != $dt->toDateString())
        {
            self::dayItemQty($dt->toDateString());
            $dt->addDay();
            $count++;
        }
        return $count;

    }

}
