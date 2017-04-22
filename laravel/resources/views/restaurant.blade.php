@extends('layout')
@section('head')
   <!-- <style>
        #map {
            height: 400px;
            width: 90%;
            margin-left:15px;
        }
    </style>-->
@endsection
@section('content')
    <?php $rest_transl = $restaurant->restaurant_transls()->where('language_code', App::getLocale())->first();
    $opening_hours = $restaurant->restaurant_schedules;
    $format = \App\Models\Restaurant::timeDisplFormat;
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 restaurant">
                <div class="row">
                    <div class="col-xs-12 text-center"><h1>{{$restaurant->name}}</h1></div>
                    <div class="col-xs-12 rest_image ">
                        <a class="thumbnail">
                            <img src="{{URL::asset('images/' . $restaurant->id . '.png')}}" alt="...">
                        </a>
                    </div>
                    <div class="col-xs-12">
                        <br>
                        <strong>{{__('Description: ')}}</strong>
                        <br>
                        {{$rest_transl->description}}
                        <br><br>
                    </div>
                    <div class="col-xs-12 col-sm-4" >
                        <strong>{{__("Menu:")}}</strong>
                        <div id="food_tree" style="overflow-y: scroll; max-height:400px "></div>
                    </div>
                    <div class="col-xs-12 col-sm-4"><span class="glyphicon glyphicon-earphone"></span>
                        &nbsp;{{$restaurant->phone}} <br>
                        <span class="glyphicon glyphicon-info-sign"></span>
                        &nbsp;<a href="http://{{$restaurant->website}}">{{$restaurant->website}}</a> <br>
                        <strong>{{ __('Address: ') }}</strong> <br>
                        {!! $address!!}
                    </div>
                    <!--<div class="col-xs-12 col-sm-4"><span class="glyphicon glyphicon-info-sign"></span>
                        &nbsp;<a href="http://{{$restaurant->website}}">{{$restaurant->website}}</a>
                    </div>-->
                    <div class="col-xs-12 col-sm-4">
                        <strong>{{__('Opening hours: ')}}</strong>
                        <table>
                        @foreach($opening_hours as $opening_hour)
                            <tr>
                                <td>{{$opening_hour->weekday_name()->where('language_code', App::getLocale())->first()->name}} &nbsp;</td>
                                <td>{{$opening_hour->time_from->format($format)}} &nbsp;-&nbsp; {{$opening_hour->time_to->format($format)}}</td>
                            </tr>
                        @endforeach
                        </table>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12" id="map"><iframe onload="mapRatio()"
                                id="map-frame"
                                width="100%"

                                frameborder="0" style="border:0; "
                        >
                        </iframe></div>

                    <script>
                        initializeEmbed();
                        function mapRatio() {
                            var mapWidth = $('#map-frame').width();
                            var mapHeight = mapWidth * window.innerHeight/ window.innerWidth;
                            $('#map-frame').height(mapHeight);
                        }
                        function initializeEmbed() {
                            var url = "https://www.google.com/maps/embed/v1/directions?key=AIzaSyC533-V9Z7cF6a8HP91E3DbX-Xq0DCz9Q0&destination={{ $restaurant->lat }},{{$restaurant->lng}}&language={{substr(App::getLocale(),0,2)}}"
                            var currLoc = localStorage["loc"];
                            if (currLoc != undefined) {
                                //use location from restaurants page
                                $('#map-frame').attr("src", url + "&origin=" + currLoc );
                            } else {
                                //use location from browser
                                navigator.geolocation.getCurrentPosition(function(pos) {
                                    $('#map-frame').attr("src", url + "&origin=" + pos.coords.latitude + ',' + pos.coords.longitude );
                                }, function() {
                                    url = "https://www.google.com/maps/embed/v1/place?key=AIzaSyC533-V9Z7cF6a8HP91E3DbX-Xq0DCz9Q0&q={{ $restaurant->lat }},{{$restaurant->lng}}&language=en"
                                    $('#map-frame').attr("src", url)

                                })
                            }

                        }
                        $('#food_tree').jstree({
                            'core' : {
                                'data' : {!! $menu !!}
                            },
                            'plugins': ['wholerow']}); //TODO look into state, search and sort plugins here

                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection