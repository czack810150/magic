<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Question;
use App\Question_category;
use App\Answer;
class QuestionController extends Controller
{
    public function index()
    {
        $subheader = 'Employee Training';
        $questions = Question::orderBy('question_category_id','asc')->orderBy('difficulty')->get();
        $stats['total'] = Question::count();
        $stats['mc'] = Question::where('mc',true)->count();
        $stats['sa'] = Question::where('mc',false)->count();
        $categories = Question_category::get();
        foreach($categories as $c){
            $stats['categories'][$c->name] = $c->question->count();
        }
        foreach($questions as $q){
            $q->category = $q->question_category?$q->question_category->name:'no category';
            $q->type = $q->mc?'选择':'简答';
            $q->created = $q->created_at->toFormattedDateString();
        }
        return view('exam.question.index',compact('questions','subheader','stats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $subheader = 'Employee Training';
        $categories = Question_category::get();
        return view('exam.question.create',compact('categories','subheader'));
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
        $subheader = 'Exmployee Training';
        $question = Question::find($id);
        return view('exam.question.question',compact('question','subheader'));
    }

  
    public function edit($id)
    {
        $subheader = 'Exmployee Training';
        $question = Question::find($id);
        $categories = Question_category::pluck('name','id');
        return view('exam.question.edit',compact('question','subheader','categories'));
    }

    public function update(Request $request, $id)
    {

        $subheader = 'Exmployee Training';
        $question = Question::find($id);
        $question->body = $request->question;
        $question->difficulty = $request->difficulty;
        $question->question_category_id = $request->category;
        $answers = Answer::where('question_id',$question->id)->get();
        if(count($answers)){
        $answers[0]->answer = $request->correct;
        $answers[0]->save();
        $answers[1]->answer = $request->answer1;
        $answers[1]->save();
        $answers[2]->answer = $request->answer2;
        $answers[2]->save();
        $answers[3]->answer = $request->answer3;
        $answers[3]->save();
        }
        $question->save();
        
        return redirect("/question/$id/show");
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
        $subheader = 'Employee Training';
        $categories = Question_category::get();
        return view('exam.question.newCategory',compact('categories','subheader'));
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
