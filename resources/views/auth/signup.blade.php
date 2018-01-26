@extends('templates.default')


@section('content')
    <h3>Sign up</h3>
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('auth.signup') }}" class="form-vertical" method="post" role="form">
                {{ csrf_field() }}

                <div class="form-group has-danger">
                    <label for="username" class="control-label">
                        <b>Choose a username</b>
                    </label>
                    <input type="text" name="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" id="username" value="{{ old('username') }}">
                    <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                </div>
                <div class="form-group has-danger">
                    <label for="email" class="form-control-label">
                        <b> Your email address</b>
                    </label>
                    <input type="text" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" value="{{ old('email') }}">
                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                </div>
                <div class="form-group has-danger">
                    <label for="password" class="control-label">
                        <b>Choose a password</b>
                    </label>
                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" value="{{ old('password') }}">
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
@stop