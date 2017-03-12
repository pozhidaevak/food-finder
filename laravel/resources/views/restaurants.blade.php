@extends('layout')
@section('content')
    <div class="container-fluid">
        <div class="row restaurants col-xs-12 col-sm-8 col-sm-offset-2">
            @foreach($restaurants as $restaurant)
                <?php $rest_transl = $restaurant->restaurant_transls()->where('language_code', App::getLocale())->first()?>
                <div class="row restaurant" id="{{$restaurant->id}}">


                    <div class="rest_name col-sm-8 col-xs-12 visible-xs-block">
                        <h1>{{$restaurant->name}}</h1>
                    </div>
                    <div class="col-xs-12 col-sm-4 rest_image ">
                        <a class="thumbnail">
                            <img src="{{URL::asset('images/' . $restaurant->id . '.png')}}" alt="...">
                        </a>
                    </div>
                    <div class="rest_name col-sm-8 col-xs-12 hidden-xs">
                        <h1>{{$restaurant->name}}</h1>
                    </div>
                    <div class="rest_description col-sm-8 col-xs-12">{{$rest_transl->description}}</div>

                    <div class="col-xs-12 col-sm-4"><span class="glyphicon glyphicon-earphone"></span> &nbsp;{{$restaurant->phone}}</div>
                    <div class="col-xs-12 col-sm-4">
                        <span class="glyphicon glyphicon-time"></span>&nbsp;{{$restaurant->OpenString()}}
                        @if($rest_transl->schedule_change)
                            <br/>
                            <i class="fa fa-warning text-danger"></i>
                           <strong> {{$rest_transl->schedule_change}}</strong>
                        @endif

                    </div>
                    <hr/>
                </div>
            @endforeach
        </div>
    </div>
@stop
