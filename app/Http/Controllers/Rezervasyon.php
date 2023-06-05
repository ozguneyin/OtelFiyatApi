<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Rezervasyon extends Controller
{

    public function check_room(Request $request){
       
    }

    public function ekle(Request $request){

        if ($request->user_id==""){
            $users = DB::table('customers')->get();
        } else {
            $request->session()->put('user_id', $request->user_id);
            $users = DB::table('customers')->where('id',$request->user_id)->first();
        }

        $hotels = DB::table('hotels')->get();
        $rooms = DB::table('rooms')->get();
        
        return view('ekle',['request'=>$request,'data'=>$users,'hotels'=>$hotels,'rooms'=>$rooms]);

    }

    public function sil(){
        
    }
    
    public function listele(Request $request){

        if ($request->user_id==""){
            $users = DB::table('customers')->get();
        } else {
            $request->session()->put('user_id', $request->user_id);
            $users = DB::table('customers')->where('id',$request->user_id)->first();
        }
        
        return view('listele',['request'=>$request,'data'=>$users]);
        
    } 
}
