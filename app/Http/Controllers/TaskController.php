<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Task;
use App\Category;
use App\Http\Resources\Task as TaskResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        //get all tasks, paginated
        $tasks = Task::paginate(15);
        //return collection of tasks as a resource
        return TaskResource::collection($tasks);
    }

    /**
     * Getting the tasks of a certain category.
     *
     * @param  string $name
     * @return AnonymousResourceCollection
     */
    public function tasks_by_category($name)
    {
        //get tasks that belong to a certain category
        $category = Category::where('name',  $name)->first();

        $tasks = $category->tasks;

        //return collection of tasks as a resource
        return TaskResource::collection($tasks);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return TaskResource
     */
    public function store(Request $request)
    {
        // USED NAME task_id FOR FORM PLZ
        $task = $request->isMethod('put') ? Task::findOrFail($request->task_id) : new Task;
        $task->id = $request->input('task_id');
        $task->subject = $request->input('task_subject');
        $task->description = $request->input('task_description');
        $category = Category::where('name', $request->input('category_name'))->first();
        $task->category()->associate($category);
        if($task->save()){
            return new TaskResource($task);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return TaskResource
     */
    public function show($id)
    {
        // get a single task
        $task = Task::findOrFail($id);
        // return the task as a resource
        return new TaskResource($task);
        // we're returning a data object
        //if you want no wrapping
        //go see app service provider comments
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return TaskResource
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
