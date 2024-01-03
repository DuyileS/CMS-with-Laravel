<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;

class PostController extends Controller
{
    public function show(Post $post){
        
        return view('blog-post', ['post' => $post]);
    }

    public function create(){
        $this->authorize('create', Post::class);
        return view('admin.posts.create');
        FacadesSession::flash('post-created-message', 'Post was created');
        return redirect()->route('post.index');
    }

    public function store(){
        $this->authorize('create', Post::class);

       $inputs = request()->validate([
            'title' => 'required|min:8|max:255', 
            'post_image' =>'file',
             'body' => 'required']);
    if(request('post_image')){
        $inputs['post_image'] = request('post_image')->store('images');
    }
    auth()->user()->posts()->create($inputs);
    FacadesSession::flash('post-created-message', 'Post was created');
    return redirect()->route('post.index');
    }

    public function index(){
        $posts =auth()->user()->posts()->paginate(5);
        return view('admin.posts.index', ['posts'=>$posts]); 
    }

    public function edit(Post $post){
        $this->authorize('view', $post);
        // if(auth()->user()->can('view', $post)){

        // }
        return view('admin.posts.edit', ['posts'=>$post]); 
    }

    public function destroy(Post $post){
        $this->authorize('delete', $post);
        $post->delete();

        FacadesSession::flash('message', 'Post has been deleted');

        return back();
    }

    public function update(Post $post){
        $inputs = request()->validate([
            'title' => 'required|min:8|max:255', 
            'post_image' =>'file',
             'body' => 'required']);
        if(request('post_image')){
         $inputs['post_image'] = request('post_image')->store('images');
         $post->post_image = $inputs['post_image'];
         }
        $post->title = $inputs['title'];
        $post->body = $inputs['body']; 
        
        $this->authorize('update', $post);

        $post->save();
        FacadesSession::flash('update-message', 'Post has been updated');
        return redirect()->route('post.index');   
    }
}

