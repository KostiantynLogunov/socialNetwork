@extends('templates.default')

@section('content')
    <h3>Update your profile</h3>

    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('profile.edit') }}" class="form-vertical" method="post" role="form">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group has-danger">
                            <label for="first_name" class="control-label">
                                First Name
                            </label>
                            <input type="text" name="first_name" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" id="first_name" value="{{ Request::old('first_name') ?: Auth::user()->first_name }}">
                            <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="form-group has-danger">
                            <label for="last_name" class="form-control-label">
                                Last Name
                            </label>
                            <input type="text" name="last_name" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" id="last_name" value="{{ Request::old('last_name') ?: Auth::user()->last_name }}">
                            <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                        </div>
                    </div>
                </div>

                    {{--<div class="col-lg-6">--}}
                        <div class="form-group has-danger">
                            <label for="location" class="control-label">
                                Location
                            </label>
                            <input type="text" name="location" class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" id="location" value="{{ Request::old('location') ?: Auth::user()->location  }}">
                            <div class="invalid-feedback">{{ $errors->first('location') }}</div>
                        </div>
                    {{--</div>--}}


                <div class="form-group">
                    <button class="btn btn-default" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
@stop