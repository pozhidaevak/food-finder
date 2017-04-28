<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{URL::to('js/app.js')}}"></script>
    <link rel="stylesheet" href="{{URL::to('css/app.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/font-awesome.css')}}">
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC533-V9Z7cF6a8HP91E3DbX-Xq0DCz9Q0&language=en&libraries=places"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/themes/default/style.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/jstree.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="{{URL::to('js/distance.js')}}"></script>
    <link rel="stylesheet" href="{{URL::to('css/style.css')}}">
    <script src="{{URL::to('js/restaurants.js')}}"></script>
    @yield('head')

</head>
<body>

    {!! Form::select('locale', $locales, $currentLocale) !!}
    @yield('content')
    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
    <script type="application/javascript" async>
        $("[name=locale]").change(function() {
            window.location.assign(window.location.pathname.replace(/^\/[a-zA-Z]{2,3}/,"\/" + this.value));
        })
        $("[name=locale]").val( window.location.pathname.match(/^\/([a-zA-Z]{2,3})/)[1]);
    </script>
    @yield('footer')
</body>
</html>
