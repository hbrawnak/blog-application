@extends('layouts.master')

@section('title')
    Post by
@endsection

@section('content')
<section class="row posts">
        <div class="col-md-6 col-md-offset-3">
              @foreach($posts as $post)
                <article class="post" data-postid="{{ $post->id }}">
                     <div class="single-info">
                     <p>{{ Auth::user()->first_name }}</p>
                     <p>{{ $post->created_at }}</p>
                     </div><br>
                    <p>{{ $post->body }}</p>
                    <div class="interaction">
                        @if(Auth::user())
                            <a href="#" class="edit">Edit</a> |
                            <a href="{{ route('post.delete', ['post_id' => $post->id]) }}">Delete</a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection