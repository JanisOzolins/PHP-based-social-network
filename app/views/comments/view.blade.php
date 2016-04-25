@extends('layouts.master')

@section('title')
Posts
@stop

@section('content')

<!-- Post Container -->
<div class="row post">
    <div class="col-md-12">
        <!-- Post Icon -->
        <div class="row" style="padding: 25px 0;">
            <div class="col-md-2">
                <div style="float: left;">
                    <img class='photo-comments' src="{{ secure_url('https://media.licdn.com/mpr/mpr/shrink_100_100/p/2/005/099/2e2/3c4a8b8.jpg') }}" alt='photo'>
                </div>
            </div>
            <!-- Post Body -->
            <div class="col-md-10">
                <div style="float: left;">
                    <a href="{{{ url('comments/'.$post->id)}}}"><h3 class="post_title"> {{{ $post->title }}}</h3></a>
                    <div style="padding: 5px 0; font-weight: bold;">Posted by {{{ $post->author }}} on  {{{ $post->created }}}</div>
                    <div >{{{ $post->message }}}</div>
                </div>
            </div>
        </div>
        <!-- Delete, Edit and Comments links -->
        <div class="row" style="padding: 15px 0px 5px;">
            <div class="col-md-12 post-tools">
                <div>
                    <a href="{{{ url('delete/'.$post->id) }}}">Delete</a>
                    <span>|</span>
                    <a href="{{{ url('edit/'.$post->id) }}}">Edit</a>
                    <span>|</span>
                    <a href="{{{ url('comments/'.$post->id) }}}">Comments ({{{ $post->comments }}})</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Comment Form -->
<div class="row">
    <div class="form-container">
        {{ Form::open(array('url' => URL::to('/submitComment/'.$post->id, array(), true))) }}
            <p>
                {{ Form::label('author') }}
                {{ Form::text('author') }}
            </p>
            <p>
                {{ Form::label('message') }}
                {{ Form::textarea('message', null, ['class'=>'form-control', 'rows' => 4, 'cols' => 40]) }}
            </p>
            <p>
                {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            </p>
        {{ Form::close() }}
    </div>
</div>

@foreach($comments as $comment)
<div class="col-md-12" style="padding: 0;">
    <!-- Comment -->
    <div class="media">
        <!-- Comment Image -->
        <a class="pull-left" href="#">
            <img class="media-object" src="{{ secure_url('https://media.licdn.com/mpr/mpr/shrink_100_100/p/2/005/099/2e2/3c4a8b8.jpg') }}" alt="">
        </a>
        <!-- Comment Body -->
        <div class="media-body">
            <h4 class="media-heading">
                {{{ $comment->author }}} <span style="float:right;"><a href="{{{ url('deleteComment/'.$comment->comment_id) }}}"><i style="float:right; color: red;" class="fa fa-times" aria-hidden="true"></i></a></span>
            </h4>
                {{{ $comment->message }}}
        </div>
    </div>
</div>
@endforeach
@stop