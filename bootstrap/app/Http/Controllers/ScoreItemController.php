<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Score_category;
use App\Score_item;

class ScoreItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subheader = "Score Settings";
        $items = Score_item::orderBy('score_category_id')->orderBy('myOrder')->get();
        return view('score.item.index',compact('items','subheader'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $subheader = "Score Settings";
        $categories = Score_category::pluck('name','id');
        return view('score.item.create',compact('categories','subheader'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $myOrder = Score_item::count();
        $category = Score_item::create([
            'score_category_id' => $request->category,
            'name' => $request->item,
            'value' => $request->value,
            'myOrder' => $myOrder+1,
        ]);
        return redirect('/score/item');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Score_item::find($id);
        $categories = Score_category::pluck('name','id');
        return view('score.item.edit',compact('categories','item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Score_item::find($id);
        $item->update(['name' => $request->item,'score_category_id'=>$request->category,'value'=>$request->value]);
        return redirect('/score/item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Score_item::destroy($id);
        return redirect('/score/item');
    }
    public function getItemsByCategory(Request $r)
    {
        $items = Score_item::where('score_category_id',$r->category)->get();
        return $items;
    }
}
