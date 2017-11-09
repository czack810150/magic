<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Score_category;

class ScoreCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subheader = "Score Settings";
        $categories = Score_category::get();
        return view('score.category.index',compact('categories','subheader'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subheader = "Score Settings";
        return view('score.category.create',compact('subheader'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $myOrder = Score_category::count();
        $category = Score_category::create([
            'name' => $request->category,
            'myOrder' => $myOrder+1,
        ]);
        return redirect('/score/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Score_category::find($id);
        return view('score.category.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Score_category::find($id);
        return view('score.category.edit',compact('category'));
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
         $category = Score_category::find($id);
         $category->update(['name' => $request->category]);

         return redirect('/score/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Score_category::destroy($id);
        return redirect('/score/category');
    }
}
