@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h3>Your friends:</h3>
            @if(!count($friends)>0)
                <p>You have not any friend.</p>
            @else
                @foreach($friends as $user)
                    @include('user.partials.userblock')
                @endforeach
            @endif

        </div>
        <div class="col-lg-6">
            <h4>Friend request</h4>
            @if(!$requests->count())
                <p>You have no friend request.</p>
            @else
                @foreach($requests as  $user)
                    @include('user.partials.userblock')
                @endforeach
            @endif

        </div>
    </div>
@stop