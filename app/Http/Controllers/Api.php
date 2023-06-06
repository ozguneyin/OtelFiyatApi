<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Api extends Controller
{

    public function RezervasyonSil(Request $request){

        if ($request->token==sha1("ozguneyin")){

            $reservations = DB::table('reservations')->where('id',$request->reservation_id)->get();
            $sayisi = count($reservations);
            if ($sayisi=="0"){
                
                $arr["status"] = "0";
                $arr["message"] = "Belirtilen Rezervasyon Bulunamadi";

            } else {

                DB::table('reservations')->where('id',$request->reservation_id)->delete();

                $arr["status"] = "1";
                $arr["message"] = "Belirtilen Rezervasyon Basariyla Silindi";
            }
           
        } else {

        $arr["status"] = "0";
        $arr["message"] = "Silme Basarisiz, Token Yanlis";

        }

        return response()->json($arr); 

    }

    public function RezervasyonSorgula(Request $request){
    
    $arr = array();
    if ($request->token==sha1("ozguneyin")){

    $arr["status"] = "1";
    $arr["message"] = "Sorgulama Basarili";    
    
    $reservations = DB::select("select id as order_id, customer_id, hotel_id, room_id, concept_id, total_nights, price_per_night, total_price  from reservations where customer_id='".$request->customer_id."'");
    if(is_array($reservations) && count($reservations)>0){
        foreach ($reservations as $rid=>$rv){
            $arr["reservations"][$rid]["order_id"] = $rv->order_id;
            $arr["reservations"][$rid]["customer_id"] = $rv->customer_id;
            $arr["reservations"][$rid]["hotel_id"] = $rv->hotel_id;
            $arr["reservations"][$rid]["room_id"] = $rv->room_id;
            $arr["reservations"][$rid]["concept_id"] = $rv->concept_id;
            $arr["reservations"][$rid]["total_nights"] = $rv->total_nights;
            $arr["reservations"][$rid]["price_per_night"] = $rv->price_per_night;
            $arr["reservations"][$rid]["total_price"] = $rv->total_price;

            $discounts = array();
            $reservation_discounts = DB::select("select d.reservation_id, d.discount_reason, d.discount_amount from reservation_discounts as d left join reservations as r ON d.reservation_id=r.id where r.customer_id='".$request->customer_id."' and d.reservation_id = '".$rv->order_id."' GROUP by d.id");
            if(is_array($reservation_discounts) && count($reservation_discounts)>0){
                foreach ($reservation_discounts as $rid=>$rv){
                $discounts[$rid]["discountReason"] = $rv->discount_reason;
                $discounts[$rid]["discountAmount"] = $rv->discount_amount;
                }
            }    

            $arr["reservations"][$rid]["discounts"] = $discounts;
        }
    }



    } else {

    $arr["status"] = "0";
    $arr["message"] = "Sorgulama Basarisiz, Token Yanlis";

    }
    return response()->json($arr); 

    }

    public function RezervasyonEkle(Request $request){
        $arr = array();

        if ($request->token==sha1("ozguneyin")){

        $hotel_info = DB::table('hotels')->where('id',$request->hotel_id)->first();     

        //Konsept Kontrolü 
        $konsept = DB::table('concepts')->where('id',$request->concept_id)->first(); 

        if ($konsept->open_for_sale=="1"){

            $arr["status"] = "1";
            $arr["message"] = "Rezervasyon Ekleme Basarili";

            $dt = [
                'customer_id' => $request->customer_id, 
                'hotel_id' => $request->hotel_id, 
                'room_id' => $request->room_id, 
                'concept_id' => $request->concept_id, 
                'total_nights' => $request->total_nights, 
                'price_per_night' => $request->price_per_night, 
                'total_price' => $request->total_price                
            ];

            DB::table('reservations')->insert($dt);
            $id = DB::getPdo()->lastInsertId();
            
            $arr["order_id"] = $id;
            $arr["reservation_data"] = $dt;

            $toplam_indirim_fiyati = 0;
            $toplam_indirimli_fiyat = 0;


            //İndirim Kuralı 1
            $total_price = floatval($request->total_price);
            
            if (floatval($total_price)>=20000){
                $indirim_miktari = 10;
                $indirim_fiyati = ($total_price*$indirim_miktari)/100;
                $indirimli_fiyat = $total_price - $indirim_fiyati;

                DB::table('reservation_discounts')->insert([
                    'reservation_id'=>$id, 
                    'discount_reason'=>'10_PERCENT_OVER_20000',
                    'discount_amount'=>$indirim_fiyati
                ]);   
                
                $arr["discounts"][0]["discount_reason"] = '10_PERCENT_OVER_20000';
                $arr["discounts"][0]["discountAmount"] = $indirim_fiyati;
                $arr["discounts"][0]["subtotal"] = $indirimli_fiyat;

                $toplam_indirim_fiyati = $toplam_indirim_fiyati+$indirim_fiyati;
            }


            //İndirim Kuralı 2
            
            if ($hotel_info->district_id=="1"){
                
                $indirim_fiyati = floatval($request->price_per_night);
                $indirimli_fiyat = $total_price - $indirim_fiyati;

                $arr["discounts"][1]["discount_reason"] = 'BUY_6_GET_1';
                $arr["discounts"][1]["discountAmount"] = floatval($request->price_per_night);
                $arr["discounts"][1]["subtotal"] = $indirimli_fiyat;

                DB::table('reservation_discounts')->insert([
                    'reservation_id'=>$id, 
                    'discount_reason'=>'BUY_6_GET_1',
                    'discount_amount'=>$request->price_per_night
                ]);  

                $toplam_indirim_fiyati = $toplam_indirim_fiyati+floatval($request->price_per_night);

            }


            //İndirim Kuralı 3
            if ($hotel_info->district_id=="2" && floatval($request->total_nights)>=2){

                if ($konsept->name=="En Ucuz Hoteller"){

                    $indirim_miktari = 25;
                    $indirim_fiyati = ($total_price*$indirim_miktari)/100;
                    $indirimli_fiyat = $total_price - $indirim_fiyati;

                $arr["discounts"][2]["discount_reason"] = '25_PERCENT_OVER_2_NIGHTS_DISTRICT_2';
                $arr["discounts"][2]["discountAmount"] = $indirim_fiyati;
                $arr["discounts"][2]["subtotal"] = $indirimli_fiyat;

                DB::table('reservation_discounts')->insert([
                    'reservation_id'=>$id, 
                    'discount_reason'=>'25_PERCENT_OVER_2_NIGHTS_DISTRICT_2',
                    'discount_amount'=>$indirim_fiyati
                ]);  

                $toplam_indirim_fiyati = $toplam_indirim_fiyati+floatval($request->price_per_night);

                }

            }


            //İndirim Kuralı 4

            if ($hotel_info->district_id=="3" && floatval($request->total_nights)>=4){

                    $indirim_miktari = 10;
                    $indirim_fiyati = ($total_price*$indirim_miktari)/100;
                    $indirimli_fiyat = $total_price - $indirim_fiyati;

                $arr["discounts"][3]["discount_reason"] = '10_PERCENT_OVER_2_NIGHTS_DISTRICT_3';
                $arr["discounts"][3]["discountAmount"] = $indirim_fiyati;
                $arr["discounts"][3]["subtotal"] = $indirimli_fiyat;

                DB::table('reservation_discounts')->insert([
                    'reservation_id'=>$id, 
                    'discount_reason'=>'10_PERCENT_OVER_2_NIGHTS_DISTRICT_3',
                    'discount_amount'=>$indirim_fiyati
                ]);  

                $toplam_indirim_fiyati = $toplam_indirim_fiyati+floatval($request->price_per_night);                

            }



            $arr["totalDiscount"] = $toplam_indirim_fiyati;
            $arr["discountedTotal"] = floatval($request->total_price)-$toplam_indirim_fiyati;


        } else {
            $arr["data"] = array();
            $arr["status"] = "0";
            $arr["message"] = "Rezervasyon Ekleme Basarisiz. Otel Konsepti Satisa Acik Degil.";
        }

        } else {
            $arr["data"] = array();
            $arr["status"] = "0";
            $arr["message"] = "Rezervasyon Ekleme Basarisiz, Token Yanlis";
        }


        

        return response()->json($arr); 
    }
}
