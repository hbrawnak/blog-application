@extends('layouts.master')

@section('title')
    Welcome!
@endsection

@section('content')
    @include('includes.message-block')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#signin" aria-controls="signin" role="tab"
                                                          data-toggle="tab">Signin</a></li>
                <li role="presentation"><a href="#signup" aria-controls="signup" role="tab"
                                           data-toggle="tab">Signup</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="signin">
                    <h3>Sign In</h3>
                    <form action="{{ route('signin') }}" method="post">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input class="form-control" type="text" name="email" id="email"
                                   value="{{ Request::old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input class="form-control" type="password" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="hidden" name="user_status" value="0" id="user_status">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="hidden" name="user_type" value="0" id="user_type">
                        </div>

                        <button type="submit" class="btn btn-default">Submit</button>
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="signup">
                    <h3>Sign Up</h3>
                    <form action="{{ route('signup') }}" method="post">
                        <div class="form-group">
                            <label for="first_name">Name:</label>
                            <input class="form-control" type="text" name="first_name" id="first_name"
                                   value="{{ Request::old('first_name') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input class="form-control" type="text" name="email" id="email"
                                   value="{{ Request::old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input class="form-control" type="password" name="password" id="password">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection