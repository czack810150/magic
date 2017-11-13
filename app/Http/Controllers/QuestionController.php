<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Question;
use App\Question_category;
use App\Answer;
class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::get();
        return view('exam.question.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Question_category::get();
        return view('exam.question.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        $question = Question::create([
            'body' => $request->question,
            'question_category_id' => $request->category,
            'difficulty' => $request->difficulty,
            'created_by' => '0'
        ]);
       

        $answer = Answer::create(['answer'=>$request->correct_answer,'correct' => true]);
        $question->answer()->save($answer); // save the correct answer first

        $question->answer()->saveMany([
            new Answer(['answer'=>$request->wrong_answer1]),
            new Answer(['answer'=>$request->wrong_answer2]),
            new Answer(['answer'=>$request->wrong_answer3]),
        ]);


        return redirect('/question');
    }
    public function storeShortAnswer(Request $request)
    {
        //dd($request);

        $question = Question::create([
            'mc' => false,
            'body' => $request->question,
            'question_category_id' => $request->category,
            'difficulty' => $request->difficulty,
            'created_by' => '0'
        ]);


        return redirect('/question');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        return view('exam.question.question',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::destroy($id);
        return redirect('/question');
    }
    public function showCategoryQuestions($id){
        $category = Question_category::find($id);
        $questions = $category->question;
        return view('exam.question.index',compact('questions'));
    }
    public function newCategory(){
        $categories = Question_category::get();
        return view('exam.question.newCategory',compact('categories'));
    }
    public function saveCategory()
    {
        $category = new Question_category;
        $category->name = request('category');
        $category->save();
        return redirect('/question_category/create');
    }
    public function removeCategory($category){
        DB::table('question_categories')->delete($category);
        return redirect('/question_category/create');
    }
    public function questionsByCategory()
    {
        return Question::where('question_category_id',request('category_id'))->get();
    }
    public function get(Request $r)
    {
        return Question::find($r->id);
    }
}
