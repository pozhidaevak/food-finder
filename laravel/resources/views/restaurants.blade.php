@extends('layout')
@section('content')
    <ul>
    @foreach($restaurants as $restaurant)
    <li>{{ $restaurant->lng }}</li>
    @endforeach
    </ul>
@stop
