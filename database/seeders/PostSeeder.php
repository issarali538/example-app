<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'title' => "The quick brown fox jumps over the lazy dogs",
            'desc' => "The is the quick brown fox jumps over the lazy dogs",
            'picture' => "uploads/issar.jpg",
            'category_id' => 1,
            'tags' => '{"tag": "tag"}',
            'user_id' => 1
        ]);
    }
}
