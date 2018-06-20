<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use App\Sale;
use App\Location;

class StoreSale extends Model
{
    protected $filllable = ['location_id','date','sales'];

    public static function computeDaily($date)
    {
        $locations = Location::NonOffice()->get();
        foreach($locations as $l)
        {
            $total = Sale::where('location_id',$l->id)->whereDate('from',$date)->sum('amount');
        }
    }
}
