{{--@foreach($users as $user)
    {{ print_r($user->id) }}
@endforeach
{{ die() }}--}}
@extends('admin.layouts.master')

@section('title')
    Admin | User Profile
@endsection

@section('admin_content')
<section class="row posts">
     <div class="col-md-6 col-md-offset-3">
         @foreach($users as $user)
             <img height="100" width="80" src="{{ route('account.image', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}" alt="Image" class="img-responsive">
             <header><h4>{{ $user->first_name }}</h4></header>
         @endforeach
     </div>
</section>

<section class="row posts">
    @include('includes.message-block')
    @foreach($users as $user)
    <form method="post" action="{{ route('update.user',$user->id) }}">
        <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
                <label for="email">Email:</label>
                <p class="form-control">{{ $user->email }}</p>
            </div>
            <div class="form-group">
                <label for="password">New Password:</label>
                <input class="form-control" type="password" name="password" id="password"/>
            </div>
             <div class="form-group">
                <label for="password">Confirm Password:</label>
                <input class="form-control" type="password" name="password_confirmation" id="password"/>
             </div>
             <input class="btn btn-default" type="submit" value="Update">
             <input type="hidden" name="_token" value="{{ Session::token() }}">
             <input class="btn btn-default" type="button" value="Change Email">
        </div>
        </form>
    @endforeach
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