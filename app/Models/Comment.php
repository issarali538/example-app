<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $guarded = [];

    public function post(): HasOne
    {
        return $this->hasOne(Post::class, "id",'post_id' );
    }

    
    public function subscriber() : HasOne{
        return $this->hasOne(Subscriber::class, "id","subscriber_id");
    }

    public function replies(){
        return $this->hasMany(Reply::class, "comment_id");
    }
}
