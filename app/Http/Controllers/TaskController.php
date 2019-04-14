<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Task;
use \App\Category;
use \App\TaskCategory;

use Illuminate\Support\Facades\Input;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task = Task::with('category')->where('created_by',\Auth::id())->paginate(5);
        // dd($task->total());
        $category = Category::all();
        return view('todo', compact('category', 'task'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
    // dd(Input::get('name'));
        $task = new Task;
        $task->task = Input::get('name');
        $task->created_by = \Auth::id();

        $task->save();
        $cat =Input::get('category');
        for( $i=0 ; $i<count($cat) ; $i++){
            $task_cat = new TaskCategory;
            $task_cat->task_id = $task->id;
            $task_cat->category_id = $cat[$i];
            $task_cat->save();
        }

        return 'success';
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $task = Task::where('id', Input::get('id'))->first();
        $task->status = ($task->status==1)?0:1;
        $task->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::where('id', $id)->delete();
    }
}
