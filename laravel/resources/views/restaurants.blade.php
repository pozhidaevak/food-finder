@extends('layout')
@section('content')
    <div class="container-fluid">
        <div class="row restaurants col-xs-12 col-sm-8 col-sm-offset-2">
            @foreach($restaurants as $restaurant)
                <?php $rest_transl = $restaurant->restaurant_transls()->where('language_code', App::getLocale())->first()?>
            <div class="row restaurant" id="{{$restaurant->id}}">
                <div class="col-xs-12 col-sm-4 rest_image">
                    <a  class="thumbnail">
                        <img src="{{URL::asset('images/' . $restaurant->id . '.png')}}" alt="...">
                    </a>
                </div>
                <div class="col-xs-12 col-sm-8">
                    <div class=" row"><div class="rest_name col-xs-12 "><h1>{{$rest_transl->name}}</h1></div></div>
                    <div class=" row"><div class="rest_description col-xs-12">{{$rest_transl->description}}</div></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">$restaurant->phone</div>
                        <div class="col-xs-12 col-sm-4">Open today</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@stop
