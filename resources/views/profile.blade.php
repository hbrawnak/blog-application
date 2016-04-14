@extends('layouts.master')

@section('title')
    @foreach($users as $name)
    {{ $name->first_name }}
    @endforeach
@endsection

@section('content')
<section class="row posts">
 <div class="col-md-6 col-md-offset-3">
 @foreach($users as $user)
 <img height="100" width="80" src="{{ route('account.image', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}" alt="Image" class="img-responsive">
 <header><h4>{{ $user->first_name }}</h4></header>
 @endforeach
 </div>
</section>

<section class="row posts">
 <div class="col-md-6 col-md-offset-3">
       @foreach($posts as $post)
         <article class="post">
             <p>{{ $post->body }}</p>
             <div class="info">
                 Posted on {{ $post->created_at }}
             </div>
         </article>
     @endforeach
 </div>
 <div class="pagination">
 {!! $posts->render() !!}
 </div>
</section>


@endsection