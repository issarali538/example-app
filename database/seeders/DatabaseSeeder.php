<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ReplySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\SubscriberSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // school::factory()->count(5)->create();
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            PostSeeder::class,
            SubscriberSeeder::class,
            CommentSeeder::class,
            ReplySeeder::class,
            SettingSeeder::class,
        ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    }
}
