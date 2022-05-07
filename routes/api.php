<?php

use App\Http\Controllers\AgamaController;
use App\Http\Controllers\DaftarCaraPembayaranController;
use App\Http\Controllers\DaftarGiziController;
use App\Http\Controllers\MInseneratorController;
use App\Http\Controllers\OxygenController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\ExaminationActionController;
use App\Http\Controllers\GeneralExaminationController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarKasusController;
use App\Http\Controllers\ActionServiceController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CorpseExaminationController;
use App\Http\Controllers\DaftarRegistrasiController;
use App\Http\Controllers\DiagnosisTypeController;
use App\Http\Controllers\EmergancyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IdentityTypeController;
use App\Http\Controllers\InPatientController;
use App\Http\Controllers\KategoriKegiatanController;
use App\Http\Controllers\KategoriKualifikasiController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KualifikasiController;
use App\Http\Controllers\LaundryTypeController;
use App\Http\Controllers\LogisticController;
use App\Http\Controllers\LogisticTypeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuleWithRoleController;
use App\Http\Controllers\OutPatienController;
use App\Http\Controllers\DiagnosticServicesController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\ExaminationServiceController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\PoliclinicTypeController;
use App\Http\Controllers\PolyclinicController;
use App\Http\Controllers\PolyclinicRoomController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\RecipeDetailServiceController;
use App\Http\Controllers\RoombedController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomgradeController;
use App\Http\Controllers\RoomserviceController;
use App\Http\Controllers\RujukanController;
use App\Http\Controllers\SupportActionServiceCOntroller;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupportServiceController;
use App\Http\Controllers\TribeController;
use App\Http\Controllers\UtdrsController;
use App\Http\Controllers\VisitController;

;
use App\Models\Incinerator;
use Illuminate\Http\Request;
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

        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('user', [AuthController::class, 'user']);
            Route::post('role', [RoleController::class, 'rolePublic']);
            Route::post('logout', [AuthController::class, 'logout']);

            Route::apiResource('roles', RoleController::class);
            Route::apiResource('users', UserController::class);
            Route::apiResource('modules', ModuleController::class);
            Route::apiResource('daftar-agama', AgamaController::class);
            Route::get('list-agama', [AgamaController::class, 'global_function']);
            Route::apiResource('daftar-cara-pembayaran', DaftarCaraPembayaranController::class);
            Route::get('list-cara-pembayaran', [DaftarCaraPembayaranController::class, 'global_function']);
            Route::apiResource('daftar-gizi', DaftarGiziController::class);
            Route::apiResource('daftar-insenerator', MInseneratorController::class);
            Route::apiResource('daftar-kasus', DaftarKasusController::class);
            Route::get('list-kasus', [DaftarKasusController::class, 'global_function']);
            Route::apiResource('daftar-oksigen', OxygenController::class);
            Route::apiResource('daftar-pekerjaan', ProfessionController::class);
            Route::get('list-pekerjaan', [ProfessionController::class, 'global_function']);
            Route::apiResource('daftar-pemeriksaan-jenazah', CorpseExaminationController::class);
            Route::apiResource('daftar-pemeriksaan-umum', GeneralExaminationController::class);
            Route::get('list-pemeriksaan-umum', [GeneralExaminationController::class,'global_function']);
            Route::apiResource('daftar-tindakan', ExaminationActionController::class);
            Route::get('list-tindakan', [ExaminationActionController::class, 'global_function']);
            Route::apiResource('daftar-pendidikan', EducationController::class);
            Route::get('list-pendidikan', [EducationController::class, 'global_fun']);
            Route::apiResource('daftar-prosedure', ProcedureController::class);
            Route::apiResource('daftar-suku', TribeController::class);
            Route::get('list-suku', [TribeController::class,'global_function']);
            Route::apiResource('daftar-utdrs', UtdrsController::class);
            Route::apiResource('daftar-identitas', IdentityTypeController::class);
            Route::get('list-provinsi', [ProvinceController::class,'global_function']);
            Route::get('list-identitas', [IdentityTypeController::class, 'global_function']);
            Route::apiResource('daftar-laundry', LaundryTypeController::class);
            Route::apiResource('daftar-logistik', LogisticTypeController::class);
            Route::apiResource('daftar-poliklinik-type', PoliclinicTypeController::class);
            Route::apiResource('logistik', LogisticController::class);
            Route::get('list-logistik', [LogisticController::class,'global_function']);
            Route::get('list-poliklinik-type', [PoliclinicTypeController::class,'global_function']);
            Route::apiResource('daftar-pasien', PatientsController::class);
            Route::get('list-pasien', [PatientsController::class,'global_function']);
            Route::apiResource('jabatan', PositionController::class);
            Route::get('list-jabatan', [PositionController::class,'global_function']);
            Route::apiResource('daftar-rujukan', RujukanController::class);
            Route::get('list-rujukan', [RujukanController::class,'global_function']);
            Route::apiResource('daftar-registrasi', DaftarRegistrasiController::class);
            Route::get('list-registrasi', [DaftarRegistrasiController::class,'global_function']);
            Route::apiResource('daftar-pegawai', EmployeeController::class);
            Route::get('list-pegawai', [EmployeeController::class,'global_function']);
            Route::apiResource('reg-rawat-inap', InPatientController::class);
            Route::apiResource('rawat-inap', InPatientController::class);

            Route::get('list-diagnosa', [DiagnosisTypeController::class,'global_function']);
            
            Route::apiResource('layanan-penunjang',SupportServiceController::class);
            Route::apiResource('layanan-diagnosa',DiagnosticServicesController::class);
            Route::apiResource('layanan-tindakan',ActionServiceController::class);
            Route::get('layanan-tindakan-rate',[ActionServiceController::class,'getRate']);
            Route::get('layanan-penunjang-rate',[SupportServiceController::class,'getRate']);
            Route::get('layanan-penunjang-radiologi',[SupportServiceController::class,'getRadiologi']);
            Route::get('layanan-penunjang-operasi',[SupportServiceController::class,'getOperasi']);
            Route::get('layanan-penunjang-insenerator',[SupportServiceController::class,'getInsenerator']);
            Route::get('layanan-penunjang-utdrs',[SupportServiceController::class,'getUtdrs']);
            Route::get('layanan-penunjang-kamarjenazah',[SupportServiceController::class,'getKamarJenazah']);
            Route::apiResource('layanan-pemeriksaan',ExaminationServiceController::class);
            Route::apiResource('layanan-resep',RecipeDetailServiceController::class);

            Route::apiResource('reg-rawat-jalan', OutPatienController::class);
            Route::put('update-pasien-pulang/{id}',[ OutPatienController::class,'updatePasienPulang']);
            Route::apiResource('penunjang-tindakan', SupportActionServiceCOntroller::class);
            Route::get('getGlobal',[ SupportActionServiceCOntroller::class,'getGlobal']);
            Route::get('rate-laboratorium',[ SupportActionServiceCOntroller::class,'rateLaboratorium']);
            Route::apiResource('rawat-jalan', OutPatienController::class);
            Route::get('rawat-jalan-detail', [OutPatienController::class,'getDetail']);
            Route::apiResource('reg-rawat-darurat', EmergancyController::class);
            Route::apiResource('kategori-kualifikasi', KategoriKualifikasiController::class);
            Route::get('list-kategori-kualifikasi', [KategoriKualifikasiController::class, 'global_function']);
            Route::apiResource('kualifikasi', KualifikasiController::class);
            Route::get('list-kualifikasi', [KualifikasiController::class, 'global_function']);
            Route::apiResource('kategori-kegiatan', KategoriKegiatanController::class);
            Route::get('list-kategori-kegiatan', [KategoriKegiatanController::class, 'global_function']);
            Route::apiResource('r-modules', ModuleWithRoleController::class);
            Route::apiResource('daftar-kegiatan', KegiatanController::class);
            Route::get('list-kegiatan', [KegiatanController::class, 'global_function']);
            Route::apiResource('poliklinik', PolyclinicController::class);
            Route::get('list-poliklinik', [PolyclinicController::class, 'global_function']);
            Route::apiResource('ruangan', PolyclinicRoomController::class);
            Route::apiResource('ranjang', RoombedController::class);
            Route::apiResource('daftar-suplier', SupplierController::class);
            Route::get('list-poliklinik-room', [PolyclinicRoomController::class, 'global_function']);
            Route::get('list-room-grade', [RoomgradeController::class, 'global_function']);
            Route::get('select-room', [RoomController::class, 'select_function']);
            Route::get('list-room', [RoomController::class, 'global_function']);
            Route::apiResource('kamar', RoomController::class);
            Route::apiResource('tarif', RateController::class);
            Route::get('tarif-keuangan', [RateController::class, 'tarifKeungan']);
            Route::apiResource('visit', VisitController::class);

            Route::get('list-penyakit', [DiseaseController::class, 'global_function']);
            
            Route::post('my-modules', [ModuleController::class, 'myModule']);

            Route::post('users/active/{id}', [UserController::class, 'active']);
            Route::post('modules/active/{id}', [ModuleController::class, 'active']);
        });
});
