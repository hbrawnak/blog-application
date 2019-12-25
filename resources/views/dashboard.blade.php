{{--@foreach($posts as $post)
{{ print_r(count(str_limit($post->body))) }}
@endforeach
{{die()}}--}}
@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    @include('includes.message-block')
    <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
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
    </section>
    <section class="row posts">
        <div class="col-md-6 col-md-offset-3">
            @foreach($posts as $post)
                <article class="post" data-postid="{{ $post->id }}">
                    <p>{{ str_limit($post->body, $limit = 200, $end ="...") }}
                        @if(strlen($post->body) >= 200 )
                            <a class="btn btn-link" href="{{ route('post', ['post_id' => $post->id]) }}" role='button'>See
                                More</a>
                        @endif
                    </p>

                    <div class="info">
                        @if(Auth::user() != $post->user)
                            Posted by <a
                                    href="{{ route('profile',[$post->user_id]) }}">{{ $post->user->first_name }}</a>
                            on {{ $post->created_at }}
                        @else
                            Posted by {{ $post->user->first_name }} on {{ $post->created_at }}
                        @endif
                    </div>
                    <div class="interaction">
                        @if(Auth::user() == $post->user)
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