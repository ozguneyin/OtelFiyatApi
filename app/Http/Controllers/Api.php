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
    $arr["bilgi"] = "Sorgulama Basarili";
    } else {
    $arr["data"] = array();
    $arr["status"] = "0";
    $arr["bilgi"] = "Sorgulama Basarisiz, Token Yanlış";
    }
    return response()->json($arr); 

    }
}
