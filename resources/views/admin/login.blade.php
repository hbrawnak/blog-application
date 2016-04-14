@extends('admin.layouts.master')

@section('title')
    Admin | Login
@endsection

@section('admin_content')
    @include('includes.message-block')
  <section class="row ">
        <div class="col-md-6 col-md-offset-3">
        <form action="{{ route('adminSignIn') }}" method="post">
            <div class="form-group">
                <label for="email">Your Email:</label>
                <input class="form-control" type="text" name="email" id="email" value="{{ Request::old('email') }}">
            </div>
            <div class="form-group">
                <label for="password">Your Password:</label>
                <input class="form-control" type="password" name="password" id="password">
            </div>
             <div class="form-group">
                <input class="form-control" type="hidden" name="user_status" value="0" id="user_status">
            </div>
            <div class="form-group">
                <input class="form-control" type="hidden" name="user_type" value="1" id="user_type">
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
            <input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
    </div>
 </section>
@endsection