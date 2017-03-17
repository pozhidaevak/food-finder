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
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->

    <!-- Fonts
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">-->

    <!-- Styles -->
    <style>
        div.my-filter-container {
            border: 1px solid #ccc;
            margin: 8px;
            padding: 8px;
            border-radius: 4px;
            background-color: #7da8c3;
        }
        div.restaurant {
            border: 1px solid #ccc;
            margin: 8px;
            padding: 8px;
            border-radius: 4px;
            background-color: #fff;
        }
        a.thumbnail {
            margin-bottom: 0px;
        }
        html, body {
            background-color: #eee;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    @yield('head')

</head>
<body>

    {!! Form::select('locale', $locales, $currentLocale) !!}
    @yield('content')
    <script type="application/javascript" async>
        $("[name=locale]").change( function() {
            window.location.assign('/' + this.value)
        })
    </script>
    @yield('footer')
</body>
</html>
