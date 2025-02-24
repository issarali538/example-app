<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\Observers\CategoryObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Category::observe(CategoryObserver::class);
        // update gate 
        Gate::define('update', function(User $user, $user_id){
            return $user->id === $user_id;
        });

        // delete gate 
        Gate::define('delete', function(User $user, $user_id){
            return $user->id === $user_id;
        });

        Gate::define('isAdmin', function(User $user){
            return $user->role == 1;
        });
    }
}
