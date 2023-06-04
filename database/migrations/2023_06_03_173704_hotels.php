<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Hotels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::dropIfExists('hotels');
        Schema::dropIfExists('concepts');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('sessions');

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('payload');
            $table->integer('last_activity')->index();
        }); 

        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('district_id');
        });


        Schema::create('concepts', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id');
            $table->integer('room_id');
            $table->float('price');
            $table->string('name');
            $table->tinyInteger('open_for_sale');
        });   

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('since');
        });   

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->nullable();
            $table->integer('hotel_id');
            $table->integer('room_id');
            $table->integer('concept_id');
            $table->integer('total_nights');
            $table->float('price_per_night');
            $table->float('total_price');
        });   

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id');
            $table->string('name');
        });   



        $a = file_get_contents(base_path().'/public/json/hotels.json');
        $b = json_decode($a,true);

        DB::table('hotels')->insert($b);


        $a = file_get_contents(base_path().'/public/json/concepts.json');
        $b = json_decode($a,true);

        DB::table('concepts')->insert($b); 


        $a = file_get_contents(base_path().'/public/json/customers.json');
        $b = json_decode($a,true);

        DB::table('customers')->insert($b); 


        $a = file_get_contents(base_path().'/public/json/reservations.json');
        $b = json_decode($a,true);

        DB::table('reservations')->insert($b); 

        $a = file_get_contents(base_path().'/public/json/rooms.json');
        $b = json_decode($a,true);

        DB::table('rooms')->insert($b); 

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
