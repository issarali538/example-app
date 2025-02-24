<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    public function comment():HasOne{
        return $this->hasOne(Comment::class, "id", "comment_id");
    }

    // public function reply_self():HasOne{
    //     return $this->hasOne(Reply::class, "reply_id", "id");
    // }
}
