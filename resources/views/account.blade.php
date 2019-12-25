@extends('layouts.master')

@section('title')
    {{ Auth::user()->first_name }}
@endsection

@section('content')
    <section class="row new-post">
        <section class="row new-post">
            <div class="col-md-6 col-md-offset-3 image-size">
                <img height="100" width="100"
                     src="{{ route('account.image', ['filename' => Auth::user()->first_name . '-' . Auth::user()->id . '.jpg']) }}"
                     alt="" class="img-responsive">
                <header><h4>{{ Auth::user()->first_name }}</h4></header>
            </div>
        </section>

        <div class="col-md-6 col-md-offset-3">
            <form method="post" action="{{ route('account.save') }}" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="first_name">Name:</label>
                    <input class="form-control" type="text" name="first_name" id="first_name"
                           value="{{ Auth::user()->first_name }}"/>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <p class="form-control">{{ Auth::user()->email }}</p>
                </div>
                <div class="form-group">
                    <label for="profile_image">Profile Image:</label>
                    <input name="image" id="image" class="form-control" type="file">
                </div>
                <input class="btn btn-default" type="submit" value="Update">
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <a class="btn btn-default" href="{{ route('password.update') }}" role="button">Change Password</a>
            </form>
        </div>
    </section>
    @include('includes.message-block')
    <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-default btn-lg post-button" data-toggle="modal" data-target="#myModal">
                Create Post
            </button>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Create Post</h4>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('post.create') }}" method="post">
                                <div class="form-group">
                                    <textarea class="form-control" name="body" rows="3"
                                              placeholder="Write your post here..."></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info">Post</button>
                                    <input type="hidden" name="_token" value="{{ Session::token() }}"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="row posts">
        <div class="col-md-6 col-md-offset-3">
            @foreach($posts as $post)
                <article class="post" data-postid="{{ $post->id }}">
                    <p>{{ $post->body }}</p>
                    <div class="info">
                        Posted by {{ Auth::user()->first_name }} on {{ $post->created_at }}
                    </div>
                    <div class="interaction">
                        @if(Auth::user())
                            <a href="#" class="edit">Edit</a> |
                            <a href="{{ route('post.delete', ['post_id' => $post->id]) }}">Delete</a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
        <div class="pagination">
            {!! $posts->render() !!}
        </div>
    </section>

    <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Post</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="post-body">Edit the Post</label>
                            <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        var token = '{{ Session::token() }}';
        var urlEdit = '{{ route('edit') }}';
    </script>
@endsection