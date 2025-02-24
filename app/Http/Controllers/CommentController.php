<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with(["post" => function($query){
            $query->where('user_id', '=', Auth::id());
        }])->get();
        // return $comments[0]->post;
        return view('admin.comments', compact('comments'));
    }

    // this function will get all comment for char Json 
    public function getComments(){
        $comments = Comment::where("post_id" , "=" , Auth::id())->get();
        return response()->json($comments);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($comment_id)
    {
        $comment = Comment::find($comment_id);
        $comment->delete();
        session()->flash("comment_status", "Comment Deleted Successfully");
        return response()->json([
            "success" => true
        ]);
    }
}
