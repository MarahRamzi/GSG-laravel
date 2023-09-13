<?php

namespace App\Providers;

use App\Models\ClassroomWork;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\Paginator;
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
        ResourceCollection::withoutWrapping(); //return response json with out warp in key(data)

        // App::setlocale('ar');
        Paginator::useBootstrapFive();
        Relation::enforceMorphMap([
            'ClassroomWork' => ClassroomWork::class,
            'Post' => Post::class,
            'user' => User::class,
        ]);
    }
}
