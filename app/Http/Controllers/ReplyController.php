<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function reply(Request $request){
        // return $request->all();
        $reply = Reply::create([
            "reply_text" => $request->reply,
            "comment_id" => $request->comment_id,
            "responder_type" => 1
        ]);

        return $reply ? back()->with('reply_status', "Reply added Successfully") : "";
    }
}
