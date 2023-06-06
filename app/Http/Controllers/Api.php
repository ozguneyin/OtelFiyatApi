<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Api extends Controller
{
    public function RezervasyonSorgula(Request $request){
    
    $arr = array();
    if ($request->token==sha1("ozguneyin")){
    $reservations = DB::table('reservations')->where('customer_id',$request->customer_id)->get();
    $arr["data"] = $reservations;
    $arr["status"] = "1";
    $arr["message"] = "Sorgulama Basarili";
    } else {
    $arr["data"] = array();
    $arr["status"] = "0";
    $arr["message"] = "Sorgulama Basarisiz, Token Yanlis";
    }
    return response()->json($arr); 

    }

    public function RezervasyonEkle(Request $request){
        $arr = array();

        if ($request->token==sha1("ozguneyin")){

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
    
            DB::table('reservations')->insert($arr);
            $id = DB::getPdo()->lastInsertId();
            
            $arr["order_id"] = $id;
            $arr["reservation_data"] = $dt;

            



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
