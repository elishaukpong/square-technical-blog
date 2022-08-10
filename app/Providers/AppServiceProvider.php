<?php

namespace App\Providers;

use App\Contracts\PostInterface;
use App\Models\Post;
use App\Observers\PostObserver;
use App\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(PostInterface::class,"App\\Repositories\\PostRepository");

        Post::observe(PostObserver::class);
    }
}
