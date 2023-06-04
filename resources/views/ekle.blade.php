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


<div class="row">

<?
  if ($request->user_id==""){
    ?>
    <div class="row"> 
      <div class="col">
        <div class="alert alert-primary" role="alert">Rezervasyon Yapacak Kullanıcıyı Seçin</div>
      </div>
    </div>   
    <?
    foreach ($data as $did=>$dv){
    
      echo'<div class="col-sm-4 mb-3">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">'.$dv->name.'</h5>
                <p class="card-text">Rezervasyon Listele</p>
                <a href="'.URL::to('/rezervasyon/'.$dv->id).'" class="btn btn-primary">Bu kullanıcıdan devam et</a>
                </div>
              </div>
            </div>';

    }
  } else { ?>

    <div class="row">
      <div class="col">
        <div class="alert alert-primary" role="alert"><strong>{{ $data->name }}</strong> Rezervasyon Yapıyor &nbsp;&nbsp; <a class="btn btn-sm btn-info" href="javascript:history.back()"><<< Geri</a></div>
      </div>
    </div> 

    <?

  }
?>

</div>


<div class="row">
      <div class="col">

      <div class="card mb-3">
        <div class="card-body">

            <strong>Sorgu URL:</strong> {{ URL::to('/') }}/api/rezervasyon-ekle<br />
            <strong>Parametreler:</strong> customer_id, hotel_id, örnek token: <?=sha1("ozguneyin")?>

        </div>
       </div>
  
      <form action="{{ route('ekle') }}" method="post">
      @csrf
      <input type="hidden" name="token" value="<?=sha1("ozguneyin")?>">
      <input type="hidden" name="customer_id" value="<?=$data->id?>">
      <button type="submit" class="btn btn-primary btn-lg">Sorgula</button>
      </form>

      </div>
    </div>  


    </div>
    </div>
</div>
</body>
</html>