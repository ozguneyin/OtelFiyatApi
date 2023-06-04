<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
    <div class="col mt-5">
    <h1>Rezervasyon RESTful Api Örneği </h1>

    <div class="list-group">
    <a href="{{ route('listele') }}" class="list-group-item list-group-item-action">Rezervasyon Listele</a>
    <a href="{{ route('ekle') }}" class="list-group-item list-group-item-action">Rezervasyon Ekle</a>
    <a href="#" class="list-group-item list-group-item-action">Rezervasyon Sil</a>
    </div>


    </div>
    </div>
</div>
</body>
</html>