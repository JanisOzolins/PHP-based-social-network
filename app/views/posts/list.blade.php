@extends('layouts.master')

@section('title')
Posts
@stop

@section('content')
<div class="row">
    <div class="form-container">
        <!-- Display error messages (if any) -->
        @if($errors->has())
            @foreach($errors->all() as $message)
                <div class="alert alert-danger">
                  <strong>ERROR:</strong> {{{ $message}}}
                </div>
            @endforeach
        @endif
        <!-- Submit a post form -->
        {{ Form::open(array('url' => URL::to('/submitPost', array(), true))) }}
            <p>
                {{ Form::label('author') }}
                {{Form::text('author') }}
            </p>
            <p>
                {{Form::label('title') }}
                {{Form::text('title') }}
            </p>
            <p>
                {{Form::label('message') }}
                {{Form::textarea('message', null, ['class'=>'form-control', 'rows' => 6, 'cols' => 40]) }}
            </p>
            <p>
                {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            </p>
        {{ Form::close() }}
    </div>
</div>
<!-- If there are NO posts to display -->
@if (count($posts) == 0)
    <p>Sorry, your timeline is empty.</p>
    
<!-- If there are posts to display -->
@else 
@foreach($posts as $post)
<!-- Post Item row -->
<div class="row post">
    <div class="col-md-12">
        <!-- Post container -->
        <div class="row" style="padding: 25px 0;">
            <!-- post icon column -->
            <div class="col-md-2">
                <div style="float: left;">
                    <img class='photo-comments' src="{{{ secure_url('https://media.licdn.com/mpr/mpr/shrink_100_100/p/2/005/099/2e2/3c4a8b8.jpg') }}}" alt='photo'>
                </div>
            </div>
            <!-- Post body column -->
            <div class="col-md-10">
                <div style="float: left;">
                    <a href="{{{ url('comments/'.$post->id) }}}"><h3 class="post_title"> {{{ $post->title }}}</h3></a>
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
@endforeach

@endif
@stop