@extends('layout')
@section('head')
    <style>
        #map {
            height: 400px;
            width: 90%;
            margin-left:15px;
        }
    </style>
@endsection
@section('content')
    <?php $rest_transl = $restaurant->restaurant_transls()->where('language_code', App::getLocale())->first();
    $opening_hours = $restaurant->restaurant_schedules;
    $format = \App\Models\Restaurant::timeDisplFormat
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
                    <div class="col-xs-12 col-sm-5">Food menu will be here<br> 1<br>2<br>3<br>4<br>5</div>
                    <div class="col-xs-12 col-sm-4 col-md-3"><span class="glyphicon glyphicon-earphone"></span>
                        &nbsp;{{$restaurant->phone}}
                    </div>
                    <div class="col-xs-12 col-sm-4"><span class="glyphicon glyphicon-info-sign"></span>
                        &nbsp;{{$restaurant->website}}
                    </div>
                    <div class="col-xs-12 col-sm-6">
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
                    <iframe
                            id="map-frame"
                            width="600"
                            height="450"
                            frameborder="0" style="border:0"
                            >
                    </iframe>
                    <div class="col-xs-12" id="map"></div>

                    <script>
                        initializeEmbed()
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
                                    url = "https://www.google.com/maps/embed/v1/place?key=AIzaSyC533-V9Z7cF6a8HP91E3DbX-Xq0DCz9Q0&q={{ $restaurant->lat }},{{$restaurant->lng}}&language={{substr(App::getLocale(),0,2)}}"
                                    $('#map-frame').attr("src", url)

                                })
                            }

                        }
                        /*var directionsDisplay;
                        var directionsService = new google.maps.DirectionsService();
                        var map;
                        var restaurant = new google.maps.LatLng({{ $restaurant->lat }}, {{$restaurant->lng}});
                        function initialize() {
                            directionsDisplay = new google.maps.DirectionsRenderer();

                            var mapOptions = {
                                zoom:7,
                                center: restaurant
                            }
                            map = new google.maps.Map(document.getElementById('map'), mapOptions);
                            directionsDisplay.setMap(map);
                        }

                        function calcRoute() {
                            var start = 'Nottingham';
                            var request = {
                                origin: start,
                                destination: restaurant,
                                travelMode: 'DRIVING'
                            };
                            directionsService.route(request, function(result, status) {
                                if (status == 'OK') {
                                    directionsDisplay.setDirections(result);
                                }
                            });
                        }
                        function initMap() {
                            var uluru = {lat: {{ $restaurant->lat }}, lng: {{$restaurant->lng}} };
                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 17,
                                center: uluru
                            });
                            var marker = new google.maps.Marker({
                                position: uluru,
                                map: map
                            });
                        }*/
                    </script>
                   <!-- <script async defer
                            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC533-V9Z7cF6a8HP91E3DbX-Xq0DCz9Q0&callback=initMap&language={{App::getLocale()}}">
                    </script>-->


                </div>
            </div>
        </div>
    </div>
@endsection