<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;

class StoreSale extends Model
{
    public static function getSales($from,$to)
    {
    	$client = new Client();
    	$link = 'http://magicnoodlehq.dd.mrsdigi.com/DigiAct.php/ajax/ItemSalesSummary';
    	$headers = [
    		'Content-Type' => 'application/json'
    	];
    	$body = [
    	 "user" => "Dashboard", 
    	 "pswd" => "cXZ278c95j9c8gU",  
    	 "DateFrom" => $from, 
    	 "DateTo"=> $to 
    	];
    	return $client->request('POST',$link,['headers' => $headers, 'body' => json_encode($body)]);

    }

    public static function sales($from,$to)
    {
    	$res = self::getSales($from,$to);
    	if($res->getStatusCode() == '200'){
    		if(isset(json_decode($res->getBody())->error)){
    			return json_decode($res->getBody());
    		} else {
    			$sales = json_decode($res->getBody());
    			return $sales;
    		} 
    		
    	} else {
    		return 'API error';
    	}
    }
}
