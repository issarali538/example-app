<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::create([
            'comment' => "Comment first",
            'comment_status' => 1,
            'post_id' => DB::table('posts')->select("id")
                    ->inRandomOrder()->first()->id,
            'subscriber_id' => DB::table('subscribers')->select("id")
                    ->inRandomOrder()->first()->id
        ]);
    }
}
