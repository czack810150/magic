<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class SalesItemsTotal extends Model
{
    protected $fillable = ['location_id','itemCode','item_category_id','name','qty','amount','date'];

    public function item_category(){
    	return $this->belongsTo('App\ItemCategory');
    }
    public static function categoryBreakdown($year,$month,$location)
    {
    	if($location == -1){
    		$location = '%';
    	}
    	return SalesItemsTotal::selectRaw('item_category_id,sum(qty) as qty,ROUND(sum(amount),0) as amount')->with('item_category')->where('location_id','like',$location)->whereYear('date',$year)->whereMonth('date',$month)->groupBy('item_category_id')->having('item_category_id','!=',9)->get();
    }
    public function item()
    {
        return $this->belongsTo('App\Item','itemCode','itemCode');
    }

    public static function getItemsTotalQty($location)
    {
        $items = Item::select('itemCode','name','price')->where('menu',1)->orderBy('item_category_id')->get();
        foreach($items as $i)
        {
            $i->qty = $i->totalQty($location)->sum('qty');
        }
        return $items;
    }

}
