<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\Worker as WorkerResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Category as CategoryResource;
use App\User;
use Illuminate\Support\Facades\DB;
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
        //$workers = User::join('workers', 'users.id', '=', 'workers.user_id' )->get();
        $workers= DB::table('users')
            ->join('workers','users.id','=','workers.user_id')->get();

        //return collection of workers as a resource
        return $workers;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $name
     * @return CategoryResource
     */
    public function addSkill($name)
    {
        $skill= Category::where('name', $name);
        $user= auth()->user();
        $user->categories->create($skill);
        return new CategoryResource($skill);

    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // not yet
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->delete()){
            return new UserResource($user);

        }
    }
}
