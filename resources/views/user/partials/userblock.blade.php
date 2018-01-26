<div class="media">
    <a href="" class="pull-left">
        <img class="media-object" src="{{ $user->getAvatarUrl() }}" alt="{{ $user->getNameOrUserName() }}">
    </a>
    <div class="media-body">
        <h4 class="meadia-heading">
            <a href="{{ route('profile.index', ['username'=>$user->username]) }}">{{ $user->getNameOrUserName() }}</a>
        </h4>
        @if($user->location)
            <p>{{ $user->location }}</p>
        @endif

        {{--<br>--}}

    </div>
</div>