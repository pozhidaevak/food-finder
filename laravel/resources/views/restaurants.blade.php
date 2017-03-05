@extends('layout')
@section('content')
    <ul>
    @foreach($restaurants as $restaurant)
    <li>{{ $restaurant->restaurant_transls()->where('language_code', App::getLocale())->first()->name }}</li>
    @endforeach
    </ul>
@stop
