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
               "password" => '$12$HPfGTifJrBlAJAJoDuZES.ryRP2WH.pFeqtY8IOIt2jxYkFf.zCr2',
               "created_at" => $now,
               "updated_at" => $now,
            ],
        ];

        foreach($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
