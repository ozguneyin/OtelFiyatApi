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
    
    public function listele(Request $request){

        if ($request->user_id==""){
            $users = DB::table('customers')->get();
        } else {
            $request->session()->put('user_id', $request->user_id);
            $users = DB::table('customers')->where('id',$request->user_id)->first();
        }
        
        return view('listele',['request'=>$request,'data'=>$users]);
        
    } 

    public function sil(Request $request){

        $reservations = DB::select('SELECT r.*, c.name as customer_name, h.name as hotel_name, ro.name as room_name, co.name as concept_name FROM reservations as r                                    left join customers as c ON r.customer_id=c.id
                                                left join hotels as h ON r.hotel_id=h.id
                                                left join rooms as ro ON r.room_id=ro.id
                                                left join concepts as co ON r.concept_id=co.id
                                            ');

        
        
        return view('sil',['request'=>$request,'reservations'=>$reservations]);
        
    } 

}
