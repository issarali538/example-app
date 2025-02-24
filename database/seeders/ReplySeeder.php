<?php

namespace Database\Seeders;

use App\Models\Reply;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Reply::create([
            'reply_text' => "Reply to the post",
            'comment_id' => DB::table('comments')->select('id')
                    ->inRandomOrder()->first()->id,
            'responder_type' => 1
       ]);
    }
}
