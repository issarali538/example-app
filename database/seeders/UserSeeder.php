<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => "issarali",
            'fullname' => "Sahibzada Issar Ali",
            'email' => "sahibzadaissarali@gmail.com",
            'role' => 1,
            'password' => "123456"
        ]);
    }
}
