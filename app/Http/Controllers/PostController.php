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

use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {

        $user = auth()->user();
        if($user->client){
            $posts=Post::where('client_id', $user->id)->get();
        } elseif ($user->worker){
            $posts=Post::whereIn('category', $user->skills)->where('country', $user->country)->get();
        } else {
            $posts = Post::paginate(5);
        }
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
        $tasks = $category->tasks;
        $posts= $tasks->load('posts');
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
        $task = Task::where('subject',  $name)->first();

        $posts = $task->posts;
        $posts= $posts->sortByDesc(function($post) {
            return $post->date;
        });
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
                $posts = $user->worker->posts;
            } else {
                $posts=[];
            }
        }
        $posts= $posts->sortByDesc(function($post) {
            return $post->date;
        });
        return PostResource::collection($posts);
    }

    public function posts_user_current($id)
    {
        $user=User::where('id', $id)->first();

        if($user->client)
        {
            if($user->client->posts) {
                $posts = Post::where('client_id', "=", $id)->where("state", "=", 0)->get();
            }
            else{
                $posts=[];
            }
        }
        else if ($user->worker) {
            if($user->worker->posts) {
                $posts = Post::where('worker_id', "=", $id)->where("state", "=", 0)->get();
            } else {
                $posts=[];
            }
        }
        $posts= $posts->sortByDesc(function($post) {
            return $post->date;
        });
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

        $address = address::where('country',  $name)->get();
        $posts = $address->load('post');
        $posts= $posts->sortByDesc(function($post) {
            return $post->date;
        });
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
        $address = address::where('city',  $name)->get();
        $posts = $address->load('post');
        $posts= $posts->sortByDesc(function($post) {
            return $post->date;
        });
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
        $post->title = $request->input('title');
        $post->task_id = $request->input('task_id');
        $post->client_id = $request->input('client_id');
        $post->date=$request->input('date');
        $post->description = $request->input('description');
        $post->price = $request->input('price');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PostResource
     */
    public function editPostState(Request $request){
        $postId = $request->input('id');
        $state = $request->input('state');
        DB::update('update posts set state = ? where id = ?',[$state, $postId]);
        $post = Post::find($postId);
        return new PostResource($post);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PostResource
     */
    public function editPostWorker(Request $request){
        $postId = $request->input('id');
        $workerId = $request->input('worker_id');
        DB::update('update posts set worker_id = ?, worker_found = ? where id = ?',[$workerId, true, $postId]);
        $post = Post::find($postId);
        return new PostResource($post);
    }

    public function deletePostWorker($id){
        DB::update('update posts set worker_id = ?, worker_found = ? where id = ?',[null, false, $id]);
        $post = Post::find($id);
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return PostResource
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return new PostResource($post);
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
