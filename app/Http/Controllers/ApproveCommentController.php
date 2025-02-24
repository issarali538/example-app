<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class ApproveCommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $comment_id)
    {   
        $comment = Comment::find($comment_id);
        $comment->comment_status = $request->comment_status;
        $request_status = $request->comment_status == 1 ? false : true;
        if($comment->save()){
            return response()->json([
                "success" => true, 
                "request_status" => $request_status,
                "message" => "comment approve"
            ]);
        }
    }
}
