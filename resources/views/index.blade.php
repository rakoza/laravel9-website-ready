@extends('layouts.app')

@section('content')
    <h1>this is home page</h1>
    @include('sections.home.hero')
    <br>
    <a href="/page">go to inner page</a>
    <br>
    <a href="/login">go to login page</a>
@endsection
