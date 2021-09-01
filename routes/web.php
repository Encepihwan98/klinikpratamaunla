<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

// Route::get('', function () {
//     return view('home');
// });
Route::get('/', function() {
    return view('layouts.base-vue');
});

Route::get('/{any}', function() {
    return view('layouts.base-vue');
})->where('any', '.*');

// Route::get('/rawat_jalan', function () {
//     return view('perawatan.rawat-jalan.index');
// });

// Route::get('/rawat_jalan/view', function () {
//     return view('perawatan.rawat-jalan.create');
// });

// Route::get('/rawat_inap', function () {
//     return view('perawatan.rawat-inap.index');
// });

// Route::get('/rawat_inap/view', function () {
//     return view('perawatan.rawat-inap.create');
// });

// Route::get('/rawat_darurat', function () {
//     return view('perawatan.rawat-darurat.index');
// });

// Route::get('/rawat_darurat/view', function () {
//     return view('perawatan.rawat-darurat.create');
// });

// Route::get('/pasien', function () {
//     return view('pasien');
// });

// Route::get('/kasir_umum', function () {
//     return view('keuangan.kasir_umum');
// });

// Route::get('/kasir_umum/view', function () {
//     return view('keuangan.rincian_transaksi');
// });

// Route::get('/registrasi/rawat-jalan', function () {
//     return view('registrasi.registrasi-rawat-jalan');
// });
// Route::get('/', function () {
//     return view('welcome');
// });
