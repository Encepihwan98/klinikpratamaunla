<?php

namespace Database\Seeders;

use App\Models\Role as ModelsRole;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsRole::create( [
            'id'=>1,
            'uuid'=>'70db6da9-4d47-4851-962a-0dc484b48e38',
            'name'=>'Super User',
            'description'=>'dapat mengakses semua module',
            'superuser'=>0,
            'created_at'=>'2021-09-20 10:14:08',
            'updated_at'=>'2021-09-20 10:14:08'
            ] );



            ModelsRole::create( [
            'id'=>2,
            'uuid'=>'7726a376-ae5e-408d-9ca6-e0eedb815332',
            'name'=>'Dokter',
            'description'=>'hak akses untuk dokter',
            'superuser'=>0,
            'created_at'=>'2021-09-21 02:50:37',
            'updated_at'=>'2021-09-21 02:50:37'
            ] );



            ModelsRole::create( [
            'id'=>3,
            'uuid'=>'8f4d0ca1-1b49-44dd-802e-e966135e3555',
            'name'=>'Suster',
            'description'=>'hak akses untuk suster',
            'superuser'=>0,
            'created_at'=>'2021-09-21 02:51:00',
            'updated_at'=>'2021-09-21 02:51:00'
            ] );



            ModelsRole::create( [
            'id'=>4,
            'uuid'=>'1caaa8be-f8fe-4889-a0f2-48e8edce37b0',
            'name'=>'Admin',
            'description'=>'Hak akses untuk admin',
            'superuser'=>0,
            'created_at'=>'2021-09-22 04:05:56',
            'updated_at'=>'2021-09-28 06:14:46'
            ] );


    }
}
