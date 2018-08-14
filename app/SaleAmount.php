<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Location;
use App\Sale_total;

class SaleAmount extends Model
{
    protected $fillable = ['location_id','tableClass','salesAmt','tax','invoiceAmt','from','to'];
    private static function getSales($from,$to)
    {
    	$client = new Client();
    	$link = 'http://magicnoodlehq.dd.mrsdigi.com/DigiAct.php/ajax/SalesSummary';
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

    			$data = self::create([
    				'location_id' => $location,
    				'tableClass' => $s->TableClass,
    				'salesAmt' => $s->SalesAmt,
    				'tax' => $s->Taxes,
    				'invoiceAmt' => $s->InvoiceAmt,
    				'from' => $from,
    				'to' => $to,
    			]);

    			$count++;	
               
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
    public static function importSales($fromDate,$toDate,$interval)
    {
    	$from = Carbon::createFromFormat('Y-m-d',$fromDate)->startOfDay();
    	$to = Carbon::createFromFormat('Y-m-d',$toDate)->startOfDay();
    	$count = 0;
    	while($from->toDateString() <= $to->toDateString())
    	{
    		
    		$count += self::daySales($from->toDateString(),$interval);
    		$from->addDay();
    	}
    	return $count;
    }
    public static function saveDailySales($date)
    {
        $locations = Location::Store()->get();
        $dt = Carbon::createFromFormat('Y-m-d',$date)->startOfDay();
        $sale = SaleAmount::whereDate('from',$dt->toDateString())->sum('invoiceAmt');
        Sale_total::create([
            'location_id' => -1,
            'date' => $date,
            'total' => round($sale,2)
        ]);
        foreach($locations as $location)
        {
            $sale = SaleAmount::where('location_id',$location->id)->whereDate('from',$dt->toDateString())->sum('invoiceAmt');
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
        $endOfMonth = $dt->copy()->endOfMonth()->toDateString();
        $count = 0;
        while($endOfMonth >= $dt->toDateString())
        {
            self::saveDailySales($dt->toDateString());
            $dt->addDay();
            $count++;
        }
        return $count;
    }

    public static function monthDailySales($location,$year,$month){

            $dt = Carbon::createFromDate($year,$month,1);
            $endOfMonth = $dt->copy()->endOfMonth()->toDateString();
            $sales = collect();
            $result = collect();
            $labels = collect();
            $values = collect();
            if($location == -1){
                while($dt->toDateString() <= $endOfMonth){
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
                while($dt->toDateString() <= $endOfMonth){
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
}
