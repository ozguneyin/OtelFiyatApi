<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
    <div class="col mt-5">
    <h1>Rezervasyon RESTful Api Örneği </h1>

    <div class="alert alert-primary" role="alert">Silinecek Rezervasyonu Seçin &nbsp;&nbsp; <a class="btn btn-sm btn-info" href="{{ URL::to('/') }}"><<< Geri</a></div> 
    </div>
</div>

<div class="row">
<div class="col">


<div class="card mb-3">
        <div class="card-body">

            <strong>Sorgu URL:</strong> {{ URL::to('/') }}/api/rezervasyon-sil<br />
            <strong>Parametreler:</strong> reservation_id, token: <?=sha1("ozguneyin")?>

        </div>
</div>

<form action="{{ route('rezervasyon_sil') }}" method="post">

<input type="hidden" name="token" value="<?=sha1('ozguneyin')?>" />
@csrf
<ul class="list-group">

  <? foreach ($reservations as $rid=>$rv){?>

  <li class="list-group-item">
    <input class="form-check-input me-1" type="radio" name="reservation_id" value="<?=$rv->id?>" <?=($rid==0 ? 'checked' : '')?>>
    <label class="form-check-label" for="reservation_id"><?=$rv->customer_name?> - <?=$rv->hotel_name?> - <?=$rv->room_name?> - <?=$rv->concept_name?></label>
  </li>  

  <?}?>


</ul>

<button type="submit" class="btn btn-danger mt-3">Rezervasyon Sil</button>

</form>

</div>
</div>
</div>

</body>
</html>