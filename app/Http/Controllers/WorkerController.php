<?php

namespace App\Http\Controllers;

use App\Http\Resources\Worker as WorkerResource;
use App\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all workers
        $workers = Worker::paginate(15);
        //return collection of workers as a resource
        return WorkerResource::collection($workers);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // USED NAME worker_id FOR FORM PLZ
        $user = $request->isMethod('put') ? User::findOrFail($request->user_id) : new User;

        $worker->id = $request->input('worker_id');
        $worker->subject = $request->input('task_subject');
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
