<?php

namespace Database\Seeders;

use App\Models\RoleWithUser;
use Illuminate\Database\Seeder;

class UserWithRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoleWithUser::create( [
            'role_id'=>1,
            'user_id'=>1,
            'created_at'=>'2021-09-20 10:14:08',
            'updated_at'=>'2021-09-20 10:14:08'
            ] );

        RoleWithUser::create( [
            'role_id'=>1,
            'user_id'=>3,
            'created_at'=>'2021-09-20 10:14:08',
            'updated_at'=>'2021-09-20 10:14:08'
            ] );

        RoleWithUser::create( [
            'role_id'=>1,
            'user_id'=>2,
            'created_at'=>'2021-09-20 10:14:08',
            'updated_at'=>'2021-09-20 10:14:08'
            ] );

    }
}
