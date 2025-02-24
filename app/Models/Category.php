<?php

namespace App\Models;

// use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// #[ObservedBy([CategoryObserver::class])]
class Category extends Model
{
    protected $guarded = [];

    public function posts() : HasMany{
        return $this->hasMany(Post::class, "category_id", "id");
    }
}
