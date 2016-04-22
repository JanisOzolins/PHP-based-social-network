@extends('layouts.master')

@section('title')
Friends
@stop

@section('content')


@if (count($friends) == 0)

<p>Sorry, you don't have any friends.</p>

@else 

<div class="container-fluid friends-page">
    <div class="row friends-grid">
        @foreach($friends as $friend)
        <div class="col-md-3"><div class="friend-container"><img class="img-responsive" src="{{{ $friend['picture'] }}}"><p class="friend-grid-name">{{{ $friend['name'] }}}</p></div></div>
        @endforeach
    </div>
</div>

</tbody>
</table>
@endif

@stop