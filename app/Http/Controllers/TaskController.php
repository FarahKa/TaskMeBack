<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Task;
use App\Http\Resources\Task as TaskResource;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get tasks
        $tasks = Task::paginate(15);
        //return collection of tasts as a resource
        return TaskResource::collection($tasks);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // USED NAME task_id FOR FORM PLZ
        $task = $request->isMethod('put') ? Task::findOrFail($request->task_id) : new Task;
        $task->id = $request->input('task_id');
        $task->subject = $request->input('task_subject');
        $task->description = $request->input('task_description');

        if($task->save()){
            return new TaskResource($task);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get a single article
        $task = Task::findOrFail($id);
        // return the tast ad a resource
        return new TaskResource($task);
        // we're returning a data object
        //if you want no wrapping
        //gosee app service provider comments
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find article
        $task = Task::findOrFail($id);
        if($task->delete()){
            return new TaskResource($task);

        }
    }
}
