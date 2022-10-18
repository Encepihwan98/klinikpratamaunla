<?php

use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PasienController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KategoriObatController;
use App\Http\Controllers\ModuleWithRoleController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ObatMasukController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RekamedisController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\RujukanController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\TindakanController;
use App\Models\Administrasi;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::post('/v1/login', [AuthController::class, 'login']);

Route::prefix('v1')->group(function () {
        // Below mention routes are public, user can access those without any restriction.
        // Create New User
        // Route::post('register', 'AuthController@register');
        // Login User
        Route::post('login', [AuthController::class, 'login']);
        Route::get('print-nota/{id}', [PembayaranController::class,'printNota']);
        Route::get('laporan-keungan', [PembayaranController::class,'printLaporanKeungan']);

        Route::get('laporan-obat', [ObatController::class,'printLapObat']);
        Route::get('print-kartuberobat/{id}', [PasienController::class,'printPdf']);
        Route::get('surat-keterangan/{id}', [PasienController::class,'SuratKeterangan']);
        Route::get('surat-rujukan/{id}', [RujukanController::class,'printSuratRujukan']);

        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('user', [AuthController::class, 'user']);
            Route::post('role', [RoleController::class, 'rolePublic']);
            Route::post('logout', [AuthController::class, 'logout']);

            Route::apiResource('roles', RoleController::class);
            Route::apiResource('users', UserController::class);
            Route::get('list-users', [UserController::class,'global_function']);
            Route::apiResource('modules', ModuleController::class);
            Route::apiResource('r-modules', ModuleWithRoleController::class);

            

            
            
            Route::post('my-modules', [ModuleController::class, 'myModule']);

            Route::post('users/active/{id}', [UserController::class, 'active']);
            Route::post('modules/active/{id}', [ModuleController::class, 'active']);

            Route::apiResource('daftar-pasien', PasienController::class);
            // menu daftar pasien
            Route::post('update-status-pasien', [PasienController::class,'statusUpdate']);
            // untuk update status pasien antri/periksa/selesai
            // parameter status-string
            Route::post('remove-status-pasien/{id}', [PasienController::class,'statusRemove']);
            
            //remove status pasien
            
            //
            Route::get('status-pasien-antri', [PasienController::class,'statusGetAntri']);
            Route::get('status-pasien-checkup', [PasienController::class,'statusGetCheckup']);
            Route::get('status-pasien', [PasienController::class,'statusGet']);
            Route::get('status-pasien-selesai', [PasienController::class,'statusGetSelesai']);
            Route::get('list-pasien',[ResepController::class,'listPasien']);
            // untuk get status pasien antri/periksa/selesai
            Route::apiResource('daftar-tindakan', TindakanController::class);
            // menu daftar tindakan
            Route::get('list-tindakan',[ TindakanController::class,'global_function']);
            // list tindakan
            Route::apiResource('rekamedis', RekamedisController::class);
            //rekamedis dari dokter
            Route::post('rekamedis-perawat', [RekamedisController::class,'tambahDataRekamedis']);
            //tambah data rekamedis dari perawat
            Route::get('get-rekamedis', [RekamedisController::class,'getRekamedis']);
            //
            Route::get('daftar-tindakan-pembayaran', [ RekamedisController::class,'getTindakan']);
            // menu rekam medis
            Route::get('detail-rekamedis-pasien/{id}', [ RekamedisController::class,'listRekamedisPasien']);
            //rekamedis detail
            Route::apiResource('resep', ResepController::class);
            Route::get('resep-pasien/{id_pasien}',[ResepController::class,'resep_pasien']);
            //menu reseps
            Route::get('get-status-resep',[ResepController::class,'getStatusResep']);
            Route::get('get-status-resep-today',[ResepController::class,'getStatusResepToday']);
            Route::get('detail-resep',[ResepController::class,'getDetailResep']);
            // get status resep ('sudah','belum)
            Route::post('update-status-resep/{id}',[ResepController::class,'updateStatusResep']);
            // update status resep ('sudah','belum)
            Route::apiResource('kategori-obat', KategoriObatController::class);
            // menu kategori obat
            Route::get('list-kategori-obat', [KategoriObatController::class,'global_function']);
            // list kategori obat
            Route::apiResource('obat', ObatController::class);
            // menu obat
            Route::get('list-obat', [ObatController::class,'global_function']);
            // list obat
            
            //print laporan obat
            Route::apiResource('pembayaran', PembayaranController::class);
            // menu pembayaran
            Route::get('list-pembayaran', [PembayaranController::class,'global_function']);
            // list pembayaran
            Route::apiResource('dokter', DokterController::class);
            // menu dokter
            Route::get('list-dokter', [DokterController::class,'global_function']);
            // list dokter
            Route::apiResource('apoteker', ApotekerController::class);
            // menu apoteker
            Route::apiResource('administrasi', AdministrasiController::class);
            // menu administrasi
            Route::apiResource('daftar-suplier', SuplierController::class);
            // menu suplier
            Route::get('list-suplier', [SuplierController::class,'global_function']);
            // list suplier
            Route::apiResource('daftar-obat-masuk', ObatMasukController::class);

            Route::apiResource('rujukan', RujukanController::class);
            // menu rujukan
            
            //
        });
});
