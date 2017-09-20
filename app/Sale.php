<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
	
    public static function totalSales($start,$end)
    {
    	
    	$sales = self::getAPISales($start,$end);
		$result = json_decode($sales);
		$salesTotal = 0;
		foreach($result as $r){
			if(isset($r->AmtSold) && $r->Location != 'Main' && $r->ItemCode != 'ZZ9900')
			$salesTotal += $r->AmtSold;
		}
		return round($salesTotal,2);
    }

    public static function getStoreSales($start,$end)
    {
    	$sales = self::getAPISales($start,$end);
		$result = json_decode($sales);
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

    public static function salesBreakDown($start,$end)
    {
    	return self::getAPISales($start,$end);
    }

    

    private static function getAPISales($start,$end){
		
		$r =  '{ "user" : "Dashboard", "pswd": "cXZ278c95j9c8gU",  "DateFrom": "'.$start.'", "DateTo": "'.$end.'" }';
		 $url = 'https://magicnoodlehq.dd.mrsdigi.com/DigiAct.php/ajax/ItemSalesSummary';
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
			   'content' => $r
		    ),
		    'ssl' => array(
			    'verify_peer' => false,
			    'verify_peer_name' => false
		    )
		);
		$context  = stream_context_create($options);
		$data['result'] = file_get_contents($url, false, $context);
		if ($data['result'] === FALSE) { /* Handle error */ }
		return $data['result'];
	}

}
