@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <h1> Blog</h1>
                    @can('create-post')
                      <a class="pull-right btn btn-sm btn-success" href="{{ route('create_post') }}">Create Post</a>
                    @endcan
                </div>
                <div class="container">
                 <div class="row">
                     <div class="col-md-10 col-md-offset-1">
                         <div class="panel panel-default">
                            <div class="panel-heading"><h3>Posts</h3></div>
                              <div class="panel-heading">Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</div>
                                 @foreach($posts as $post)
                                   <div class="panel-body">
                                       <li style="list-style-type:disc">
                                      
                                         <h3><a href="{{ route('edit_post', ['id' => $post->id]) }}">{{ $post->title }}</a></h3>
                                         <p>{{ str_limit($post->body, 50) }}</p>
                                          @can('update-post', $post)
                                          <p>
                                             <a href="{{ route('edit_post', ['id' => $post->id]) }}" class="btn btn-sm btn-primary" role="button">Edit</a>
                                             <a href="{{ route('delete_post', ['id' => $post->id]) }}" class="btn btn-sm btn-danger" role="button">Delete</a>  
                                          </p>
                                         @endcan
                                      </li>
                                   </div>
                                  @endforeach
                              </div>
                          </div>
                     </div>
                    
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection