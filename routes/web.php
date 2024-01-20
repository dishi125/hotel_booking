<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
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
   $countries = array("AL","AX","DZ","AS","AD","AO","AI","AQ","AG","AR","AM","AW","AU","AT","AZ","BS","BH","BD","BB","BY","BE","BZ","BJ","BM","BT","BO","BQ","BA","BW","BV","BR","IO","BN","BG","BF","BI","CV","KH","CM","CA","KY","CF","TD","CL","CN","CX","CC","CO","KM");
   return view('welcome');
});

Route::post('/tocken', [App\Http\Controllers\BookingController::class, 'index']);
Route::post('/offer', [App\Http\Controllers\BookingController::class, 'offer']);

Route::post('/first_refer_submit', [App\Http\Controllers\BookingController::class, 'first_refer_submit']);
Route::post('/second_refer_submit', [App\Http\Controllers\BookingController::class, 'second_refer_submit']);
