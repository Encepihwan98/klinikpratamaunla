<?php

namespace Database\Seeders;

use App\Models\User as ModelsUser;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsUser::create( [
            'id'=>1,
            'uuid'=>'1',
            'name'=>'Icksan N',
            'username'=>'icksann',
            'address'=>'Jl',
            'phone'=>'6283822145705',
            'email'=>'icksannugrahaa@gmail.com',
            'email_verified_at'=>'2021-09-20 17:12:43',
            'password'=>'$2y$10$Gmplr9xzcEKXdY5314XMfOC68iEmcde468LDbRekLuJpCeTFVTIEa',
            'status'=>1,
            'api_token'=>NULL,
            'remember_token'=>NULL,
            'created_at'=>NULL,
            'updated_at'=>'2021-09-26 14:31:33'
            ] );



            ModelsUser::create( [
            'id'=>2,
            'uuid'=>'09398467-ead8-4df2-baaf-fea457632656',
            'name'=>'Super User',
            'username'=>'superuser',
            'address'=>'Jl. Cijagra gang 4 no 40',
            'phone'=>'6283822145706',
            'email'=>'su@gmail.com',
            'email_verified_at'=>NULL,
            'password'=>'$2y$10$Gmplr9xzcEKXdY5314XMfOC68iEmcde468LDbRekLuJpCeTFVTIEa',
            'status'=>1,
            'api_token'=>NULL,
            'remember_token'=>NULL,
            'created_at'=>'2021-09-21 03:20:42',
            'updated_at'=>'2021-09-28 10:06:30'
            ] );



            ModelsUser::create( [
            'id'=>3,
            'uuid'=>'4609387e-fce9-4bed-99b0-86c723a809f6',
            'name'=>'Encep Ikhwans',
            'username'=>'pecne',
            'address'=>'Jl. Cijagra gang 4 no 40',
            'phone'=>'62828192929213',
            'email'=>'encep@gmail.com',
            'email_verified_at'=>NULL,
            'password'=>'$2y$10$Dtqp5sTKVRwCrMHlu2nJMu/JrHpT1DBwNuEI9egu1NlHRg49SB7ZK',
            'status'=>1,
            'api_token'=>NULL,
            'remember_token'=>NULL,
            'created_at'=>'2021-09-28 10:12:58',
            'updated_at'=>'2021-09-28 10:13:13'
            ] );


    }
}
