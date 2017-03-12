@extends('layout')
@section('head')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="{{URL::to('js/distance.js')}}"></script>
    <script type="application/javascript">
        $( function() {
            var handle = $( "#custom-handle" );
            $( "#slider" ).slider({
                create: function() {
                    handle.text( $( this ).slider( "value" ) );
                },
                slide: function( event, ui ) {
                    handle.text( ui.value );
                },
                step:0.1,
                max:20,
                value:1
            });
        } );
        var aut;
        function locAutocomplete() {
            var input = document.getElementById("loc-text");
            aut = new google.maps.places.Autocomplete(input);
            google.maps.event.addDomListener(input, 'keydown', function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();

                }
            });
        }
        function locFilter() {
            var targetDist = $('#slider').slider('value');
            var targetLat = aut.getPlace().geometry.location.lat();
            var targetLng = aut.getPlace().geometry.location.lng();
            $('div.restaurant').each(function (){
                var currLat = $(this).attr('lat');
                var currLng = $(this).attr('lng');
                if (distance(targetLat,targetLng, currLat, currLng, 'M') > targetDist) { //TODO handle different units
                    $(this).hide()
                } else {
                    $(this).show()
                }
            })
            //alert(aut.getPlace().name + aut.getPlace().geometry.location)
        }
    </script>
    <style>
        #custom-handle {
            width: 3em;
            height: 1.6em;
            top: 50%;
            margin-top: -.8em;
            text-align: center;
            line-height: 1.6em;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <!-- filter box on top of the page -->
        <div class="row col-xs-12 col-sm-8 col-sm-offset-2"><div class="row my-filter-container ">

                <div class="food-tree col-xs-12 col-sm-4">Food tree (TBD)</div>

                <!-- Location search-->
                <div class="loc-search col-xs-12 col-sm-8"> {{__("Search by location: ")}}
                   <br/> {{__("Distance from location: ")}}

                    <div id="slider" style="margin: 8px; ">
                        <div id="custom-handle" class="ui-slider-handle"></div>
                    </div>
                    <form>
                        <div class="input-group">
                        <input type="text" onfocus="locAutocomplete()" id="loc-text" class="form-control" placeholder="{{__("Input location or place...")}}">
                        <span class="input-group-btn">
                            <button class="btn btn-default" onclick="locFilter()" type="button">{{__("Go!")}}</button>
                        </span>


                        </div>


                        </form>

                </div>

            </div></div>

            <!-- List of restaurants-->
            <div class="row restaurants col-xs-12 col-sm-8 col-sm-offset-2">
                @foreach($restaurants as $restaurant)
                    <?php $rest_transl = $restaurant->restaurant_transls()->where('language_code', App::getLocale())->first()?>
                    <div class="row restaurant" id="{{$restaurant->id}}" lng="{{$restaurant->lng}}" lat="{{$restaurant->lat}}">


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

                        <div class="col-xs-12 col-sm-4"><span class="glyphicon glyphicon-earphone"></span>
                            &nbsp;{{$restaurant->phone}}</div>
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
@stop
