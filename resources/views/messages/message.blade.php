@extends('templates.default')

@section('content')
    <style>
        .lastMsg:hover {
            background-color: lightgrey;
        }
    </style>

    <div class="messedger" style="display: flex; flex-direction: row; justify-content: space-between;">
        <div class="left col-lg-6 offset-lg-3" style="border-right:1px solid darkgrey">
            <h3 class="text-center">Mesenger</h3>
            @if(isset($conversations))
                @foreach($conversations as $conversation)
                    <?php
                        $lastMsgId = \Chatty\Message::where('conversation_id', $conversation->id)->max('id');
                        $lastMsg = \Chatty\Message::find($lastMsgId);
                        $from_user = \Chatty\User::find($lastMsg->from_user_id);
                    ?>
                    <a href="{{ route('messaeges.read', ['conversation_Id'=>$conversation->id]) }}" style="text-decoration: none">
                        <div class="lastMsg p-3" style="{{ $lastMsg->readed ? '' : 'background-color: lightgrey;' }} ">
                            <h6><img class="media-object" src="{{ $from_user->getAvatarUrl() }}" alt="{{ $from_user->getNameOrUserName() }}">
                            {{$from_user->getNameOrUserName()}}</h6>
                            {{mb_strimwidth($lastMsg->text, 0, 30,  '...')}}
                        </div>
                    </a>
                    <br>
                @endforeach
            @endif
        </div>
    </div>



@stop