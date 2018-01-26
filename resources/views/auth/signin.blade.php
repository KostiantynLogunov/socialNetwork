@extends('templates.default')


@section('content')
    <h3>Sign in</h3>
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('auth.signin') }}" class="form-vertical" method="post" role="form">
                {{ csrf_field() }}
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
                <div class="checkbox">
                    <label for="">
                        <input type="checkbox" name="remember">Remember me
                    </label>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
@stop