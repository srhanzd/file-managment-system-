<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => '123456',
                'is_admin' => '1',
            ],
//            [
//                'name' => 'User',
//                'email' => 'user@gmail.com',
//                'password' => '13456',
//                'is_admin' => null,
//            ],
//            [
//                'name' => 'Client',
//                'email' => 'client@gmail.com',
//                'password' => '13456',
//                'is_admin' => null,
//            ]
        ];

        foreach($users as $user)
        {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'is_admin' => $user['is_admin'],
                'password' => Hash::make($user['password'])
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
