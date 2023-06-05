<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Rezervasyon extends Controller
{

    public function check_concepts(Request $request){

        $concepts = DB::table('concepts')->where([
            ['hotel_id',$request->hotel_id],
            ['room_id',$request->room_id]
        ])->get();

        return response()->json($concepts); 
    }

    public function check_room(Request $request){
        $rooms = DB::table('rooms')->where('hotel_id',$request->hotel_id)->get();
        return response()->json($rooms); 
    } 

    public function ekle(Request $request){

        if ($request->user_id==""){
            $users = DB::table('customers')->get();
        } else {
            $request->session()->put('user_id', $request->user_id);
            $users = DB::table('customers')->where('id',$request->user_id)->first();
        }

        $hotels = DB::table('hotels')->get();
        
        return view('ekle',['request'=>$request,'data'=>$users,'hotels'=>$hotels]);

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
