<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Rezervasyon;
use App\Http\Controllers\Api;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('main');
});


Route::get('/rezervasyon', [Rezervasyon::class, 'ekle'])->name("ekle");

Route::get('/rezervasyon/{user_id}', [Rezervasyon::class, 'ekle'])
        ->name('user_id')
        ->missing(function (Request $request) {
            return view('main');
        });


Route::get('/rezervasyon-listele', [Rezervasyon::class, 'listele'])->name("listele");
Route::get('/rezervasyon-sil', [Rezervasyon::class, 'sil'])->name("sil");

Route::get('/rezervasyon-listele/{user_id}', [Rezervasyon::class, 'listele'])
                ->name('user_id')
                ->missing(function (Request $request) {
                    return view('main');
                });                

Route::post('/api/rezervasyon-sorgula', [Api::class, 'RezervasyonSorgula'])->name("sorgula");                
Route::post('/api/rezervasyon-ekle', [Api::class, 'RezervasyonEkle'])->name("rezervasyon_ekle");                
Route::post('/api/rezervasyon-sil', [Api::class, 'RezervasyonSil'])->name("rezervasyon_sil");                

Route::get('/rezervasyon-ekle', [Rezervasyon::class, 'ekle'])->name("rez_ekle");                

Route::post('/check_room', [Rezervasyon::class, 'check_room'])->name("check_room");                
Route::post('/check_concepts', [Rezervasyon::class, 'check_concepts'])->name("check_concepts");