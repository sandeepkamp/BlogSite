<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Gate;
use Auth;
use Session;
use App\Http\Requests\UpdatePost as UpdatePostRequest;

class PostController extends Controller
{
       public function index()
      {
         $posts = Post::published()->paginate();
         return view('posts.index', compact('posts'));
       }



      public function store(Request $request) { 

        
            $this->validate($request, [
              'title' => 'required|max:255',
              'body'  => 'required'
            ]);
          
            $post = new Post;
            Post::create([
                'body' => request('body'),
                'title' => request('title'),
                'user_id' => auth()->id(),
                'slug' => str_slug(request('title'), '-')
            ]);

            return redirect()->route('list_posts')
            ->with('flash_message','Article successfully created');
            //$post->['user_id'] = $request->Auth::user()->id;
           // $post->title = $request->input('title');
           // $post->body = $request->input('body');
          ///  $post->slug = str_slug($request->input('title'), '-');
          //  $post->save();
          
           // Session::flash('success', 'The blog post was successfully saved!');
          
           //$post = Post::create($data);
          // return redirect()->route('edit_post', ['id' => $post->id]);
        }


     /*  public function store(StorePostRequest $request)
    {
    $data = $request->only('title', 'body');
    $data['slug'] = str_slug($data['title']);
    $data['user_id'] = Auth::user()->id;
    $post = Post::create($data);
    return redirect()->route('edit_post', ['id' => $post->id]);
    }*/

       public function drafts()
       {
           $postsQuery = Post::unpublished();
           if(Gate::denies('see-all-drafts')) {
               $postsQuery = $postsQuery->where('user_id', Auth::user()->id);
           }
           $posts = $postsQuery->paginate();
           return view('posts.drafts', compact('posts'));
       }


        public function publish(Post $post)
        {
          $post->published = true;
          $post->save();
         return back();
       }

        public function show($id)
        {
         $post = Post::published()->findOrFail($id);
         return view('posts.show', compact('post'));
        }

        public function create()
        {
           return view('posts.create');
        }

        public function edit(Post $post)
        {
            return view('posts.edit', compact('post'));
        }

       public function update(Post $post, UpdatePostRequest $request)
       {
          $data = $request->only('title', 'body');
          $data['slug'] = str_slug($data['title']);
          $post->fill($data)->save();
          return back();
       }

         /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index') ->with('flash_message','Article successfully deleted');
    }
}
