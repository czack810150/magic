<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Score_category;
use Carbon\Carbon;
class Score_log extends Model
{
    protected $fillable =['date','location_id','employee_id','score_item_id','value'];

    public function score_item()
    {
    	return $this->belongsTo('App\Score_item');
    }
    public function location()
    {
    	return $this->belongsTo('App\Location');
    }
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public static function reviewScore($eid,$date){
        $dt = Carbon::createFromFormat('Y-m-d',$date)->startOfDay();
        $scores = self::with('score_item.score_category')->where('employee_id',$eid)->whereDate('date','>=',$dt->subDays(180)->toDateString())->get();
        $result = collect();
        $result->put('score',100);
        $result->put('pass',true);
        $items = collect();
        $categories = Score_category::get();
        foreach($categories as $c){
            
            $c->infractions = 0;
            $cateItems = array();
            // array_push($cateItems,'infractions' => 0);
            foreach($scores as $s){
                if($s->score_item->score_category_id == $c->id){
                    array_push($cateItems,$s->score_item);
                    if($s->value < 0){
                        $c->infractions += 1;
                        $result['score'] -= 1;
                    } 
                } 
            }
            $c->items = $cateItems;
            if($c->infractions >= $c->allowance){
                $result['pass'] = false;
            }
        }
        $result->put('categories',$categories);
        return $result;
    }
}
