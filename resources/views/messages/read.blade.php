@extends('templates.default')

@section('content')
    {{--<div class="messedger" style="display: flex; flex-direction: row; justify-content: space-between;">--}}
    <div class="messedger">
        <h3 class="text-center">Messenger</h3>
        <div class="left col-lg-8 offset-lg-2" style="border:1px solid darkgrey; border:1px solid darkgrey">

            <br>
            <div class="header" style="display: flex; justify-content: space-between">
                <div class="left">
                    <a href="{{ route('messaeges.index') }}">
                        <img src="{{asset('img/back1.png')}}" alt="Back" style="height: 50px">
                    </a>
                </div>
                <div class="center">
                    @if(isset($userSecond))
                        <a href="{{ route('profile.index', ['username'=>$userSecond->username]) }}">
                            <h5>{{$userSecond->getNameOrUserName() }}</h5>
                        </a>
                    @endif
                </div>
                <div class="right">
                    <a href="{{ route('profile.index', ['username'=>$userSecond->username]) }}">
                        <img class="media-object" src="{{ $userSecond->getAvatarUrl() }}" alt="{{ $userSecond->getNameOrUserName() }}">
                    </a>
                </div>
            </div>
            @if(isset($chat))
                @foreach($chat as $item)
                    @if($item->from_user_id == Auth::user()->id)
                        <div class="float-right align-text-bottom  col-6 p-3 m-2" style="color: whitesmoke; background-color: #0069D9; border-radius: 10px">
                            {{ $item->text }} <br>
                        </div>
                        <div class="clearfix"></div>
                    @else
                        <div class="col-6 p-3 m-2" style="background-color: lightgrey; border-radius: 10px">
                                <h6>{{ $userSecond->getNameOrUserName() }}:</h6>
                              {{ $item->text }} <br>
                        </div>
                    @endif
                @endforeach
            @endif
            <div class=" align-bottom">
                <form action="{{ route('friends.sendMsg', ['username'=>$userSecond->username]) }}" method="post">
                    {{csrf_field()}}
                    <textarea name="bodyMessage" rows="5" class="mt-2 w-100"></textarea>
                    <div class="text-right m-2">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop