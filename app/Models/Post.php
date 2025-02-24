<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

#[ObservedBy([PostObserver::class])]
class Post extends Model
{
    protected $guarded = [];

    public function user():HasOne{
        return $this->hasOne(User::class, "id","user_id");
    }

    public function category():HasOne{
        return $this->hasOne(Category::class, "id", "category_id");
    }

    public function comments(): HasMany{
        return $this->hasMany(Comment::class, "post_id", "id");
    }
    
    public function subscriber(): HasManyThrough{
        return $this->hasManyThrough(Comment::class,Subscriber::class, "id", "post_id");
    }

}
