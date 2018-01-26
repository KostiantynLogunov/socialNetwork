<nav class="navbar navbar-expand-xl navbar-dark bg-dark">
    <div class="container ">
        <a class="navbar-brand" href="{{ route('home') }}">Chatty</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Timeline</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('friends.index') }}">
                            Friends
                            @if(isset($countRequests) && $countRequests>0)
                                <span class="text-warning">
                                    (+{{ $countRequests }})
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('messaeges.index') }}">
                            Messages
                            @if(isset($newMessages) && $newMessages>0)
                                <span class="text-warning">
                                    (+{{ $newMessages }})
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <form class="form-inline my-2 my-lg-0" action="{{ route('search.results') }}">
                            <input class="form-control mr-sm-2" type="text" placeholder="Find people" aria-label="search" name="query">
                            <button class="btn btn-light my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav my-2 my-lg-0">
                @if(Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.index', ['username'=>Auth::user()->username]) }}">{{Auth::user()->getNameOrUserName() }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">Update profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.signout') }}">Sign Out</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.signup') }}">Sign up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.signin') }}">Sign in</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>