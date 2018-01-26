@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            @include('user.partials.userblock')
            <hr>
            @if(!$statuses->count())
                <p>{{ $user->getFirstNameOrUserName() }} hasn't posted anything yet.</p>
            @else
                @foreach($statuses as $status)
                    <div class="media">
                        <a href="{{ route('profile.index', ['username'=>$status->user->username]) }}" class="pull-left">
                            <img class="media-object" src="{{ $status->user->getAvatarUrl() }}" alt="{{ $status->user->getNameOrUserName() }}">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="{{ route('profile.index', ['username'=>$status->user->username]) }}">{{ $status->user->getNameOrUserName() }}</a></h4>
                            <p>{{ $status->body}}</p>
                            <ul class="list-inline">
                                <li class="list-inline-item">{{ $status->created_at->diffForHumans()}}</li>
                                @if($status->user->id !== Auth::user()->id)
                                    <li class="list-inline-item"><a href="{{ route('status.like', ['statusId'=>$status->id]) }}">Like</a></li>
                                @endif
                                <li class="list-inline-item">{{ $status->likes->count() }} {{str_plural('like', $status->likes->count())}}</li>
                            </ul>

                            @foreach($status->replies as $reply)
                                <div class="media">
                                    <a href="{{ route('profile.index', ['username'=> $reply->user->username]) }}" class="pull-left">
                                        <img class="media-object" src="{{ $reply->user->getAvatarUrl() }}" alt="{{ $reply->user->getNameOrUserName() }}">
                                    </a>
                                    <div class="media-body">
                                        <h5 class="media-heading"><a href="{{ route('profile.index', ['username'=> $reply->user->username]) }}">{{ $reply->user->getNameOrUserName() }}</a></h5>
                                        <p>{{ $reply->body }}</p>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">{{ $reply->created_at->diffForHumans() }}</li>
                                            @if($reply->user->id !== Auth::user()->id)
                                                <li class="list-inline-item"><a href="{{ route('status.like', ['statusId'=>$reply->id]) }}">Like</a></li>
                                            @endif
                                            <li class="list-inline-item">{{ $reply->likes->count() }} {{str_plural('like', $reply->likes->count())}}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach

                            @if($authUserIsFriend || Auth::user()->id === $status->user->id)
                                <form action="{{ route('status.replay', ['statusId'=>$status->id]) }}" method="post">
                                    {{csrf_field()}}
                                    <div class="form-group  has-danger">
                                        <textarea name="reply-{{ $status->id }}"  class="form-control {{ $errors->has("reply-$status->id") ? 'is-invalid' : '' }}" id="email" value="{{ old("reply-$status->id") }}" rows="2"  placeholder="Replay to this status"></textarea>
                                        <div class="invalid-feedback">{{ $errors->first("reply-$status->id") }}</div>
                                    </div>

                                    <input type="submit" value="Replay" class="btn btn-outline-dark btn-sm">
                                </form>
                            @endif
                            <br>
                        </div>
                    </div>
                @endforeach
                {{--{!! $statuses->render() !!}--}}
            @endif
        </div>

        <div class="col-lg-4 offset-lg-3">
            @if(Auth::user()->hasfriendRequestPending($user))
                <p>Waiting for {{ $user->getNameOrUserName() }} to accept your request.</p>
            @elseif(Auth::user()->hasfriendRequestReceived($user))
                <a href="{{ route('friends.accept' ,['username'=>$user->username]) }}" class="btn btn-primary">Accept friend request</a>
            @elseif(Auth::user()->isFriendWith($user))
                <p>You and {{ $user->getNameOrUserName() }} are friends</p>

                <form action="{{ route('friends.delete',['username'=>$user->username]) }}" method="post">
                    {{csrf_field()}}
                    <input type="submit" class="btn btn-outline-danger" value="Delete freind">
                </form>
                <br>
                {{--<form action="--}}{{--{{ route('friends.sendMsg',['username'=>$user->username]) }}--}}{{--" method="post">
                    {{csrf_field()}}
                    <input type="submit" class="btn btn-outline-primary" value="Message">
                </form>--}}
            <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#MessageModal">
                    Message
                </button>

                <!-- Modal -->
                <div class="modal fade" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="MessageModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="color: whitesmoke; background-color: #0069D9">
                                <h5 class="modal-title" id="MessageModalLabel">New message</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span><a class="text-right" href="#" style="color: whitesmoke; font-size: medium; font-style: normal; font-family: Arial;">Messages history</a></span>
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body"  style="background-color: #F7F7F7">
                                <a href="{{ route('profile.index', ['username'=>$user->username]) }}" class="pull-left">
                                    <img class="media-object" src="{{ $user->getAvatarUrl() }}" alt="{{ $user->getNameOrUserName() }}">
                                    {{ $user->getNameOrUserName() }}
                                </a>
                                <br>
                                <br>
                                <form action="{{ route('friends.sendMsg', ['username'=>$user->username]) }}" method="post">
                                    {{csrf_field()}}
                                    <textarea name="bodyMessage" id="bodyMessage" class="w-100" rows="5"></textarea>
                                    <br><br>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
            @elseif(Auth::user()->id !== $user->id)
                <a href="{{ route('friends.add', ['username'=>$user->username]) }}" class="btn btn-primary">Add as friend</a>
            @endif
<h4>{{ $user->getNameOrUserName() }}'s friends.</h4>
@if(!$user->friends()->count())
    <p>{{ $user->getNameOrUserName() }} has not any friend.</p>
@else
    @foreach($user->friends() as $user)
        @include('user.partials.userblock')
    @endforeach
@endif
</div>
</div>
@stop