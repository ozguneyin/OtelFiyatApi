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

Route::get('/rezervasyon-listele/{user_id}', [Rezervasyon::class, 'listele'])
                ->name('user_id')
                ->missing(function (Request $request) {
                    return view('main');
                });                

Route::post('/api/rezervasyon-sorgula', [Api::class, 'RezervasyonSorgula'])->name("sorgula");                

Route::post('/api/rezervasyon-ekle', [Api::class, 'RezervasyonEkle'])->name("ekle");                