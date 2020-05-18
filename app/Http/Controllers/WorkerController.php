<?php

namespace App\Http\Controllers;

use App\Http\Resources\Worker as WorkerResource;
use App\Http\Resources\User as UserResource;
use App\User;
use App\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        //get all workers
        $workers = User::join('workers', 'users.id', '=', 'workers.user_id' );
        //return collection of workers as a resource
        return UserResource::collection($workers);
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
