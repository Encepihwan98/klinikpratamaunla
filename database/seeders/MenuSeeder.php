<?php

namespace Database\Seeders;

use App\Models\Menu as ModelsMenu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsMenu::create([
            'id' => 8,
            'uuid' => '690fec3b-2b48-405c-9c23-29b8054fb8fe',
            'name' => 'Beranda',
            'slug' => 'dashboard',
            'url' => 'http://localhost:8000/dashboard',
            'parent_id' => 0,
            'api_module' => NULL,
            'order' => 1,
            'icon' => 'far fa-chart-line',
            'component' => './pages/Dashboard.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 09:27:28',
            'updated_at' => '2021-09-21 09:27:28'
        ]);

        ModelsMenu::create([
            'id' => 9,
            'uuid' => 'e0b630b1-0268-4509-adce-9672e2e615c1',
            'name' => 'Pendaftaran Pasien',
            'slug' => 'pendaftaran-pasien',
            'url' => 'http://localhost:8000/administrasi/pendaftaran-pasien',
            'parent_id' => 0,
            'api_module' => NULL,
            'order' => 2,
            'icon' => 'far fa-calendar-alt',
            'component' => './pages/administrasi/PendaftaranPasien.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 09:29:25',
            'updated_at' => '2021-09-21 09:29:25'
        ]);

        ModelsMenu::create([
            'id' => 10,
            'uuid' => '37ab253e-4dd9-4c44-9454-b33fcab201da',
            'name' => 'Data Pasien Terdaftar',
            'slug' => 'data-pasien-terdaftar',
            'url' => 'http://localhost:8000/administrasi/data-pasien-terdaftar',
            'parent_id' => 0,
            'api_module' => NULL,
            'order' => 3,
            'icon' => 'far fa-wallet',
            'component' => './pages/administrasi/DataPasienTerdaftar.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 09:30:23',
            'updated_at' => '2021-09-21 09:30:23'
        ]);

        ModelsMenu::create([
            'id' => 11,
            'uuid' => '7a49d8c5-6855-42df-b2be-143b20b8b2aa',
            'name' => 'Pemeriksaan Pasien',
            'slug' => 'pemeriksaan-pasien',
            'url' => 'http://localhost:8000/pemeriksaan/pemeriksaan-pasien',
            'parent_id' => 0,
            'api_module' => NULL,
            'order' => 4,
            'icon' => 'far fa-book-medical',
            'component' => './pages/pemeriksaan/PemeriksaanPasien.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 09:32:57',
            'updated_at' => '2021-09-21 09:32:57'
        ]);

        ModelsMenu::create([
            'id' => 12,
            'uuid' => '02ddd360-0c2d-424b-9fcb-8bb0a8a0d903',
            'name' => 'Data Rekam Medis',
            'slug' => 'data-rekam-medis',
            'url' => 'http://localhost:8000/rekamedis/data-rekam-medis',
            'parent_id' => 0,
            'api_module' => NULL,
            'order' => 5,
            'icon' => 'far fa-hospital-user',
            'component' => './pages/rekamedis/DataRekamMedis.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 09:34:17',
            'updated_at' => '2021-09-21 09:34:17'
        ]);

        ModelsMenu::create([
            'id' => 13,
            'uuid' => '8fd13713-3a29-408e-a59a-44742e7e4d8e',
            'name' => 'Data Resep',
            'slug' => 'data-resep',
            'url' => 'http://localhost:8000/resep/data-resep',
            'parent_id' => 0,
            'api_module' => NULL,
            'order' => 6,
            'icon' => 'far fa-boxes-alt',
            'component' => './pages/resep/DataResep.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 09:35:43',
            'updated_at' => '2021-09-21 09:35:43'
        ]);

        ModelsMenu::create([
            'id' => 14,
            'uuid' => 'e96238c3-1fde-49bd-ba97-bd1fd662c5bd',
            'name' => 'Resep Hari Ini',
            'slug' => 'resep',
            'url' => 'http://localhost:8000/resep/resep',
            'parent_id' => 0,
            'api_module' => NULL,
            'order' => 7,
            'icon' => 'far fa-hospital-user',
            'component' => './pages/resep/Resep.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 10:46:13',
            'updated_at' => '2021-09-21 10:46:13'
        ]);

        ModelsMenu::create([
            'id' => 15,
            'uuid' => 'd505fd77-663c-424d-adb9-b509d8496e19',
            'name' => 'Data Obat',
            'slug' => 'data-obat',
            'url' => 'http://localhost:8000/obat/data-obat',
            'parent_id' => 0,
            'api_module' => NULL,
            'order' => 8,
            'icon' => 'far fa-hospital-user',
            'component' => './pages/obat/DataObat.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 10:48:18',
            'updated_at' => '2021-09-21 10:48:18'
        ]);

        ModelsMenu::create([
            'id' => 16,
            'uuid' => '99393631-f287-4a00-8708-8285b7a90eee',
            'name' => 'Kategori Obat',
            'slug' => 'kategori-obat',
            'url' => 'http://localhost:8000/obat/kategori-obat',
            'parent_id' => 0,
            'api_module' => NULL,
            'order' => 9,
            'icon' => 'far fa-money-check-alt',
            'component' => './pages/obat/KategoriObat.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 10:49:51',
            'updated_at' => '2021-09-21 10:49:51'
        ]);

        ModelsMenu::create([
            'id' => 17,
            'uuid' => '88696631-f287-7a00-8708-8665b7a40eik',
            'name' => 'Pembayaran',
            'slug' => 'pembayaran',
            'url' => 'http://localhost:8000/pembayaran/pembayaran',
            'parent_id' => 0,
            'api_module' => NULL,
            'order' => 10,
            'icon' => 'far fa-money-check-alt',
            'component' => './pages/pembayaran/pembayaran.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 10:49:51',
            'updated_at' => '2021-09-21 10:49:51'
        ]);

        ModelsMenu::create([
            'id' => 18,
            'uuid' => '99996631-f287-7a00-9876-8665b7a40emn',
            'name' => 'Rujukan',
            'slug' => 'rujukan',
            'url' => 'http://localhost:8000/rujukan/rujukan',
            'parent_id' => 0,
            'api_module' => NULL,
            'order' => 10,
            'icon' => 'far fa-money-check-alt',
            'component' => './pages/rujukan/rujukan.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 10:49:51',
            'updated_at' => '2021-09-21 10:49:51'
        ]);

        ModelsMenu::create([
            'id' => 19,
            'uuid' => '789112d9-6612-4906-a91e-fd41bd8e9087',
            'name' => 'Master Data',
            'slug' => '#',
            'url' => '#',
            'parent_id' => 0,
            'api_module' => NULL,
            'order' => 11,
            'icon' => 'far fa-database',
            'component' => '.',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 1,
            'created_at' => '2021-09-21 10:53:05',
            'updated_at' => '2021-09-21 10:53:05'
        ]);

        ModelsMenu::create([
            'id' => 20,
            'uuid' => '789112d9-6612-4906-a91e-fd41bd8e8790',
            'name' => 'Daftar Tindakan',
            'slug' => 'daftar-tindakan',
            'url' => 'http://localhost:8000/masterdata/daftar-tindakan',
            'parent_id' => 19,
            'api_module' => NULL,
            'order' => 1,
            'icon' => 'far fa-database',
            'component' => './pages/masterdata/DaftarTindakan.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 10:53:05',
            'updated_at' => '2021-09-21 10:53:05'
        ]);

        ModelsMenu::create([
            'id' => 26,
            'uuid' => '789112d9-6612-4906-a91e-fd41bd8e8791',
            'name' => 'Daftar Dokter',
            'slug' => 'daftar-dokter',
            'url' => 'http://localhost:8000/masterdata/daftar-dokter',
            'parent_id' => 19,
            'api_module' => NULL,
            'order' => 1,
            'icon' => 'far fa-database',
            'component' => './pages/masterdata/DaftarDokter.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 10:53:05',
            'updated_at' => '2021-09-21 10:53:05'
        ]);

        ModelsMenu::create([
            'id' => 27,
            'uuid' => '789112d9-6612-4906-a91e-fd41bd8e8792',
            'name' => 'Daftar Apoteker',
            'slug' => 'daftar-apoteker',
            'url' => 'http://localhost:8000/masterdata/daftar-apoteker',
            'parent_id' => 19,
            'api_module' => NULL,
            'order' => 1,
            'icon' => 'far fa-database',
            'component' => './pages/masterdata/DaftarApoteker.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 10:53:05',
            'updated_at' => '2021-09-21 10:53:05'
        ]);

        ModelsMenu::create([
            'id' => 28,
            'uuid' => '789112d9-6612-4906-a91e-fd41bd8e8793',
            'name' => 'Daftar Administrasi',
            'slug' => 'daftar-administrasi',
            'url' => 'http://localhost:8000/masterdata/daftar-administrasi',
            'parent_id' => 19,
            'api_module' => NULL,
            'order' => 1,
            'icon' => 'far fa-database',
            'component' => './pages/masterdata/DaftarAdministrasi.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 10:53:05',
            'updated_at' => '2021-09-21 10:53:05'
        ]);

        ModelsMenu::create([
            'id' => 29,
            'uuid' => '789112d9-6612-4906-a91e-fd41bd8e6733',
            'name' => 'Obat Masuk',
            'slug' => 'obat-masuk',
            'url' => 'http://localhost:8000/masterdata/obat-masuk',
            'parent_id' => 19,
            'api_module' => NULL,
            'order' => 1,
            'icon' => 'far fa-database',
            'component' => './pages/masterdata/ObatMasuk.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 10:53:05',
            'updated_at' => '2021-09-21 10:53:05'
        ]);
        ModelsMenu::create([
            'id' => 30,
            'uuid' => '789112d9-6612-4809-a91e-fd41bd8e6770',
            'name' => 'Daftar Supliers',
            'slug' => 'daftar-suplier',
            'url' => 'http://localhost:8000/masterdata/daftar-suplier',
            'parent_id' => 19,
            'api_module' => NULL,
            'order' => 1,
            'icon' => 'far fa-database',
            'component' => './pages/masterdata/DaftarSuplier.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 10:53:05',
            'updated_at' => '2021-09-21 10:53:05'
        ]);

        ModelsMenu::create([
            'id' => 21,
            'uuid' => '42ccc697-6215-4b27-9ed3-29d4e3fff751',
            'name' => 'System',
            'slug' => '#',
            'url' => '#',
            'parent_id' => 0,
            'api_module' => NULL,
            'order' => 12,
            'icon' => 'far fa-cogs',
            'component' => '.',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 1,
            'created_at' => '2021-09-21 10:53:31',
            'updated_at' => '2021-09-21 10:53:31'
        ]);

        ModelsMenu::create([
            'id' => 22,
            'uuid' => '00762b06-cf8e-4570-956e-f9eca0927d4c',
            'name' => 'Manajemen Role',
            'slug' => 'role-management',
            'url' => 'http://localhost:8000/system/role-management',
            'parent_id' => 21,
            'api_module' => 'roles',
            'order' => 1,
            'icon' => 'far fa-user-shield',
            'component' => './pages/system/RoleManagement.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 12:59:03',
            'updated_at' => '2021-09-21 12:59:03'
        ]);

        ModelsMenu::create([
            'id' => 23,
            'uuid' => 'd0456291-7c66-4ee9-b1f0-fcf1df8a6eaa',
            'name' => 'Manajemen User',
            'slug' => 'user-management',
            'url' => 'http://localhost:8000/system/user-management',
            'parent_id' => 21,
            'api_module' => 'users',
            'order' => 2,
            'icon' => 'far fa-user-cog',
            'component' => './pages/system/UserManagement.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 13:00:11',
            'updated_at' => '2021-09-21 13:00:11'
        ]);

        ModelsMenu::create([
            'id' => 24,
            'uuid' => '52452a79-43f8-4a00-9914-bd6646e3ba35',
            'name' => 'Manajemen Module',
            'slug' => 'module-management',
            'url' => 'http://localhost:8000/system/module-management',
            'parent_id' => 21,
            'api_module' => 'modules',
            'order' => 3,
            'icon' => 'far fa-sliders-v',
            'component' => './pages/system/ModuleManagement.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-21 13:01:45',
            'updated_at' => '2021-09-24 10:10:51'
        ]);

        ModelsMenu::create([
            'id' => 25,
            'uuid' => '9daef5e9-5d7f-45a4-a4ba-4f4e24ec2103',
            'name' => 'Manajemen Akses Module',
            'slug' => 'access-module-management',
            'url' => 'http://localhost:8000/system/access-module-management',
            'parent_id' => 21,
            'api_module' => 'r-modules',
            'order' => 4,
            'icon' => 'far fa-bars',
            'component' => './pages/system/AccessModuleManagement.vue',
            'must_login' => 1,
            'is_active' => 1,
            'is_parent' => 0,
            'created_at' => '2021-09-24 08:35:10',
            'updated_at' => '2021-09-26 14:38:00'
        ]);

       
    }
}
