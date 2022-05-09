@extends('layouts.app')

@section('content')
    <h1>this is inner page</h1>
    @include('sections.page.hero')
    <br>
    <a href="/">go to home page</a>
    <br>
    <a href="/login">go to login page</a>
@endsection
