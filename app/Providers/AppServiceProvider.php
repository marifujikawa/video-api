<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Services\Interfaces\VideoServiceInterface::class,
            \App\Services\VideoService::class
        );

        $this->app->bind(
            \App\Repositories\VideoRepositoryInterface::class,
            \App\Repositories\VideoRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
