<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function scopeMenuItems($query){
    	return $query->where('menu',true);
    }
    public function item_category(){
    	return $this->belongsTo('App\ItemCategory');
    }
    public function totalQty()
    {
    	return $this->hasMany('App\SalesItemsTotal','itemCode','itemCode');
    }
}
