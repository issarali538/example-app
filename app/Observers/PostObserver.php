<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\User;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {  
        //  $user = User::find($post->user_id);
        // if($user){
        //     $user->increment('nos_of_posts');
        // }
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        // $user = User::find($post->user_id);
        // if($user->nos_of_posts != 0){
        //     $user->decrement('nos_of_posts');
        // }
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
