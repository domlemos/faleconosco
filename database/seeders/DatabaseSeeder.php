<?php

namespace Database\Seeders;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $users = [
            [
               "name" => "Admin",
               "email" => "admin@admin.com",
               "email_verified_at" => $now,
               "password" => '$2y$12$3qqOBr5tfqe907NIIbsMP.i39.oHMq3RItod94DL6zj3xc6O.4t/G',
               "created_at" => $now,
               "updated_at" => $now,
               "type" => "admin",
            ],[
               "name" => "User",
               "email" => "user@user.com",
               "email_verified_at" => $now,
               "password" => '$2y$12$3qqOBr5tfqe907NIIbsMP.i39.oHMq3RItod94DL6zj3xc6O.4t/G',
               "created_at" => $now,
               "updated_at" => $now,
               "type" => "user",
            ],
        ];

        foreach($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
