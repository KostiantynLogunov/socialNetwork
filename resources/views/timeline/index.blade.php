@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('status.post') }}" method="post">
                {{csrf_field()}}
                <div class="form-group has-danger">
                    <textarea name="status" rows="2" placeholder="What's up {{ Auth::user()->username }} ?" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" value="{{ old('status') }}"></textarea>
                    <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                    <br>
                    <button type="submit" class="btn btn-outline-dark">Update status</button>
                </div>
            </form>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            @if(!$statuses->count())
                <p>There's nothing in your timeline, yet.</p>
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
                                            <li class="list-inline-item">{{ $reply->likes->count() }}     {{str_plural('like', $reply->likes->count())}}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach

                            <form action="{{ route('status.replay', ['statusId'=>$status->id]) }}" method="post">
                                {{csrf_field()}}
                                <div class="form-group  has-danger">
                                    <textarea name="reply-{{ $status->id }}"  class="form-control {{      $errors->has("reply-$status->id") ? 'is-invalid' : '' }}"            id="email" value="{{ old("reply-$status->id") }}" rows="2"           placeholder="Replay to this status"></textarea>
                                    <div class="invalid-feedback">{{ $errors->first("reply-$status->id") }}</div>
                                </div>

                                <input type="submit" value="Replay" class="btn btn-outline-dark btn-sm">
                            </form>
                            <br>
                        </div>
                    </div>
                @endforeach
                {!! $statuses->render() !!}
            @endif
        </div>
    </div>
@stop