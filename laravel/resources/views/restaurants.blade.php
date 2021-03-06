@extends('layout')
@section('head')



    <script type="application/javascript">
        $(function () {
            createFoodTree({!! $foods !!});
        });
    </script>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- filter box on top of the page -->
        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
            <div class="row my-filter-container ">
                <!-- Food search-->
                <div class="food-tree col-xs-12 col-sm-4">{{__("Search by food: ")}}<br/>
                    <div id="food_tree" style="overflow-y: scroll; max-height:120px "></div>
                </div>

                <!-- Location search-->
                <div class="loc-search col-xs-12 col-sm-8"> {{__("Search by location: ")}}
                    <br/> {{__("Distance(mi): ")}}

                    <div id="slider" style="margin: 8px; ">
                        <div id="custom-handle" class="ui-slider-handle"></div>
                    </div>
                    <form>
                        <div class="input-group">
                            <input type="text" onfocus="locAutocomplete()" id="loc-text" class="form-control"
                                   placeholder="{{__("Input location or place...")}}">
                            <span class="input-group-btn">
                                <button class="btn btn-default" onclick="locFilter()"
                                        type="button">{{__("Go!")}}</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- List of restaurants-->
        <div class="restaurants col-xs-12 col-sm-8 col-sm-offset-2">
            @foreach($restaurants as $restaurant)
                <script type="application/javascript">
                    restFoods[{{$restaurant->id}}] = {!! $restaurant->foods()->get(['path'])!!}
                    .map(function (a) {
                        return a.path
                    });
                </script>
                <?php $rest_transl = $restaurant->restaurant_transls()->where('language_code', App::getLocale())->first()?>
                <div class="row restaurant" id="{{$restaurant->id}}" lng="{{$restaurant->lng}}"
                     lat="{{$restaurant->lat}}">
                    <div class="rest_name col-sm-8 col-xs-12 visible-xs-block">
                        <h1><a href="{{ '/' . App::getLocale() . '/' . $restaurant->id}}"
                               target="_blank">{{$restaurant->name}}</a></h1>
                    </div>
                    <div class="col-xs-12 col-sm-4 rest_image ">
                        <a class="thumbnail">
                            <img src="{{URL::asset('images/' . $restaurant->id . '.png')}}" alt="...">
                        </a>
                    </div>
                    <div class="col-sm-8 col-xs-12 nopadding">
                        <div class="rest_name col-xs-12 hidden-xs">
                            <h1><a href="{{ '/' . App::getLocale() . '/' . $restaurant->id}}"
                                   target="_blank">{{$restaurant->name}}</a></h1>
                        </div>
                        <div class="rest_description col-xs-12">{{$rest_transl->description}}</div>
                        <div class="col-xs-12 col-sm-4"><span class="glyphicon glyphicon-earphone"></span>
                            &nbsp;{{$restaurant->phone}}
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <span class="glyphicon glyphicon-time"></span>&nbsp;{{$restaurant->OpenString()}}
                            @if($rest_transl->schedule_change)
                                <br/>
                                <i class="fa fa-warning text-danger"></i>
                                <strong> {{$rest_transl->schedule_change}}</strong>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-4 distance">
                            <span class="glyphicon glyphicon-road"></span>
                            <span class="dist-text"></span>
                        </div>
                    </div>
                    <hr/>
                </div>
            @endforeach
        </div>
    </div>
@stop