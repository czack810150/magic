<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesItemsTotal extends Model
{
    protected $fillable = ['location_id','itemCode','item_category_id','name','qty','amount','date'];
}
