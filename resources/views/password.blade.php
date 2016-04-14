@extends('layouts.master')

@section('title')
    Change Password
@endsection

@section('content')
@include('includes.message-block')
<section class="row new-post">
 <div class="col-md-6 col-md-offset-3">
       <form method="post" action="{{ route('password.save') }}">
        <div class="form-group">
            <label for="password">New Password:</label>
            <input class="form-control" type="password" name="password" id="password">
        </div>
         <div class="form-group">
            <label for="password">Confirm Password:</label>
            <input class="form-control" type="password" name="password_confirmation" id="password">
         </div>
        <input class="btn btn-default" type="submit" value="Update">
        <input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
    </div>
 </section>
@endsection