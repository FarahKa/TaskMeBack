<?php

namespace App\Http\Controllers;

use App\Category;
use App\Client;
use App\Http\Resources\Post as PostResource;
use App\Address;
use App\Post;
use App\Task;

use App\User;
use App\Worker;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        //get all tasks, paginated
        $posts = Post::paginate(5);
        //return collection of tasks as a resource
        return PostResource::collection($posts);
    }

    /**
     * Getting the posts of a certain category.
     *
     * @param  string $name
     * @return AnonymousResourceCollection
     */
    public function posts_by_category($name)
    {
        //get posts that belong to a certain category
        $category = Category::where('name',  $name)->first();

        $posts = $category->tasks->posts->paginate(5);

        //return collection of posts as a resource
        return PostResource::collection($posts);
    }

    /**
     * Getting the posts of a certain task.
     *
     * @param  string $name
     * @return AnonymousResourceCollection
     */
    public function posts_by_task($name)
    {
        //get tasks that belong to a certain category
        $task = Task::where('name',  $name)->first();

        $posts = $task->posts->paginate(5);;

        //return collection of tasks as a resource
        return PostResource::collection($posts);
    }

    /**
     * Getting posts of a certain user
     * @param int $id
     * @return AnonymousResourceCollection
     */
    public function posts_by_user($id)
    {
        $user=User::where('id', $id)->first();

        /*var_dump($user->worker); var_dump($user->client);
        var_dump($user);die();

        if($worker= Worker::firstWhere('user_id', $id)){

            $posts = $worker->posts;
            var_dump($posts);
        } else if ($client= Client::firstWhere('user_id', $id)){
            $posts = $client->posts;
        } else {
         die("problem here");
            $posts=[];
        }

        */
        if($user->client)
        {
            if($user->client->posts) {
                $posts = $user->client->posts;
            }
            else{
                $posts=[];
            }
        }
        else if ($user->worker) {
            if($user->worker->posts) {
                var_dump($user->worker->posts);
                $posts = $user->worker->posts;
            } else {
                $posts=[];
            }
        }
        return PostResource::collection($posts);
    }
    //post by country
    /**
     * Getting the posts of a country.
     *
     * @param  string $name
     * @return AnonymousResourceCollection
     */
    public function posts_by_country($name)
    {
        //get tasks that belong to a certain category
        $address = address::where('country',  $name)->first();

        $posts = $address->posts->paginate(5);;

        //return collection of tasks as a resource
        return PostResource::collection($posts);
    }

    //post by city
    /**
     * Getting the posts of a city.
     *
     * @param  string $name
     * @return AnonymousResourceCollection
     */
    public function posts_by_city($name)
    {
        //get tasks that belong to a certain category
        $address = address::where('city',  $name)->first();

        $posts = $address->posts->paginate(5);;

        //return collection of tasks as a resource
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PostResource
     */
    public function store(Request $request)
    {
        // USED NAME post_id FOR FORM PLZ
        $post = $request->isMethod('put') ? Post::findOrFail($request->post_id) : new Post;
        $post->id = $request->input('post_id');
        $post->task_id = $request->input('task_id');
        $post->client_id = $request->input('client_id');
        $post->date=$request->input('date');
        $post->description = $request->input('description');
        $address=$request->isMethod('put') ? $post->address : new Address;
        $address->country= $request->input('country');
        $address->city= $request->input('city');
        $address->postal_code= $request->input('postal_code');
        $address->street= $request->input('street');
        $address->house_number= $request->input('house_number');
        $address->save();
        $post->address()->associate($address);
        if($post->save()){
            return new PostResource($post);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return PostResource
     */
    public function show($id)
    {
        // get a single task
        $post = Post::findOrFail($id);
        // return the task as a resource
        return new PostResource($post);
        // we're returning a data object
        //if you want no wrapping -- I took off the wrapping but i have no idea where the wrapping stuff is written
        //go see app service provider comments
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return PostResource
     */
    public function destroy($id)
    {
        //find article
        $post = Post::findOrFail($id);
        if($post->delete()){
            return new PostResource($post);

        }
    }


}
