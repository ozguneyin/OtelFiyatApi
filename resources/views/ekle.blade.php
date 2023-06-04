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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
            <strong>Parametreler:</strong> customer_id, hotel_id, room_id, concept_id, total_nights, price_per_night, total_price, token: <?=sha1("ozguneyin")?>

        </div>
       </div>
  
      <form action="{{ route('ekle') }}" method="post">
      @csrf


      <div class="mb-3 row">
        <label for="staticCustomer" class="col-sm-2 col-form-label">Müşteri</label>
        <div class="col-sm-10">
          <input type="text" readonly class="form-control-plaintext"  value="{{ $data->name }}">
          <input type="hidden" name="customer_id" value="<?=$data->id?>">
          <input type="hidden" name="token" value="<?=sha1("ozguneyin")?>">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="hotel_id" class="col-sm-2 col-form-label">Hotel</label>
        <div class="col-sm-10">
          <select class="form-control" id="hotel_id" name="hotel_id" required>
            <option value="">Seçiniz</option>
            <?
            foreach ($hotels as $hid=>$hv){
              echo'<option value="'.$hv->id.'">'.$hv->name.'</option>';
            }
            ?>
          </select>
        </div>
      </div>      

      <div class="mb-3 row">
        <label for="room_id" class="col-sm-2 col-form-label">Oda</label>
        <div class="col-sm-10">
          <select class="form-control" name="room_id"></select>
        </div>
      </div>     

      <div class="mb-3 row">
        <label for="concept_id" class="col-sm-2 col-form-label">Konsept</label>
        <div class="col-sm-10">
          <select class="form-control" name="concept_id"></select>
        </div>
      </div>    

      <div class="mb-3 row">
        <label for="price_per_night" class="col-sm-2 col-form-label">Gece Fiyatı</label>
        <div class="col-sm-10">
          <select class="form-control" name="price_per_night"></select>
        </div>
      </div>    

      <div class="mb-3 row">
        <label for="total_nights" class="col-sm-2 col-form-label">Toplam Gece Sayısı</label>
        <div class="col-sm-10">
          <select class="form-control" name="total_nights"></select>
        </div>
      </div>  

      <div class="mb-3 row">
        <label for="total_price" class="col-sm-2 col-form-label">Toplam Ücret</label>
        <div class="col-sm-10">
          <select class="form-control" name="total_price"></select>
        </div>
      </div>    

      

      <button type="submit" class="btn btn-primary btn-lg">Sorgula</button>
      </form>

      </div>
    </div>  


    </div>
    </div>
</div>
<script language="javascript">
	$('#hotel_id').on('change','',function(){
    alert('merhaba');
  });
</script>
</body>
</html>