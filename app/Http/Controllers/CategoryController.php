<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category as CategoryResource;
use App\Task;
use App\Http\Resources\Worker as WorkerResource;
use App\Worker;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        //get all tasks, paginated
        $categories = Category::paginate(15);
        //return collection of tasks as a resource
        return CategoryResource::collection($categories);
    }

    /**
     * Getting the tasks of a certain category.
     *
     * @param Request $request
     * @return CategoryResource
     */
    public function category_from_task(Request $request)
    {
        //get category of a task from task id
        $task = Task::where('id',  $request->input('task_id'))->first();

        $category = $task->category();

        //return collection of tasks as a resource
        return new CategoryResource($category);
    }


    /**
     * Store a newly created category in storage.
     *
     * @param Request $request
     * @return CategoryResource
     */
    public function store(Request $request)
    {
        // USED NAME_id FOR FORM PLZ
        $category = $request->isMethod('put') ? Category::findOrFail($request->category_id) : new Category;
        $category->id = $request->input('category_id');
        $category->name = $request->input('category_name');
        $category->description = $request->input('category_description');
        if($category->save()){
            return new CategoryResource($category);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CategoryResource
     */
    public function show($id)
    {
        // get a single task
        $category = Category::findOrFail($id);
        // return the task as a resource
        return new CategoryResource($category);
        // we're returning a data object
        //if you want no wrapping
        //go see app service provider comments
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return CategoryResource
     */
    public function destroy($id)
    {
        //find article
        $category = Category::findOrFail($id);
        if($category->delete()){
            return new CategoryResource($category);

        }
    }

    /**
     * Getting the users by category, takes a category's name.
     *
     * @param  string $name
     * @return AnonymousResourceCollection
     */
    public function worker_by_category($name)
    {
        $category = category::where('name', $name)->first();


        $workers = $category->workers;

        //return collection of tasks as a resource
        return WorkerResource::collection($workers);
    }

    /**
     * Getting the users by category, takes a category's name.
     *
     * @param  string $id
     * @return AnonymousResourceCollection
     */
    public function category_by_worker($id)
    {
        $worker = worker::where('id', $id)->first();


        $categories = $worker->categories;

        return CategoryResource::collection($categories);
    }



}

