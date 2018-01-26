{{--
@extends('errors::layout')

@section('title', 'Error 404')

@section('message', 'Sorry BRO, we are having a temporary problem. We have been alerted and will be rolling out a fix soon')--}}

@extends('templates.default')

@section('content')
    <h3>Oops, that page could not be found.</h3>
    <a href="{{ route('home') }}">Go home</a>
@stop
