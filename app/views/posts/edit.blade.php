@extends('layouts.master')

@section('title')
Posts
@stop

@section('content')

<div class="col-md-12">
    <div class='post'>
        <div class="row" style="padding: 20px 0;">
            <div class="col-md-2">
                <div style="float: left;">
                    <img class='photo-comments' src="{{ secure_url('https://media.licdn.com/mpr/mpr/shrink_100_100/p/2/005/099/2e2/3c4a8b8.jpg') }}" alt='photo'>
                </div>
            </div>
            <div class="col-md-10">
                <div style="float: left;">
                    <a href="{{{ url('comments/'.$post->id)}}}"><h3 class="post_title"> {{{ $post->title }}}</h3></a>
                    <div style="padding: 5px 0; font-weight: bold;">Posted by {{{ $post->author }}} on  {{{ $post->created }}}</div>
                    <div >{{{ $post->message }}}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div style="float: left;"></div>
            </div>
            <div class="col-md-6">
                <div style="float: right;">
                    <a href="{{{ url('delete/'.$post->id)}}}">Delete</a>
                    <span>|</span>
                    <a href="{{{ url('edit/'.$post->id)}}}">Edit</a>
                    <span>|</span>
                    <a href="{{{ url('comments/'.$post->id)}}}">Comments ({{{ $post->comments }}})</a>
                </div>
            </div>
        </div>
        
    </div>
</div>  


<div class="col-md-12">
    <div class="form-container">
    {{ Form::open(array('url' => URL::to('/updatePost', array(), true))) }}
        <p>
            {{Form::label('author') }}
            {{Form::text('author', $post->author) }}
        </p>
        <p>
            {{Form::label('title') }}
            {{Form::text('title', $post->title) }}
        </p>
        <p>
            {{Form::label('message') }}
            {{Form::textarea('message', $post->message) }}
        </p>
        <p>
            {{Form::hidden('id', $post->id) }}
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }} <a href="{{ secure_url('./') }}" class="btn btn-default">Back</a>
        </p>
    {{ Form::close() }}
    </div>
</div>
@stop