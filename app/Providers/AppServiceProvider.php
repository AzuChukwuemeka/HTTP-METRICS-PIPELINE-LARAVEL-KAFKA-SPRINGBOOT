<?php

namespace App\Providers;

use App\Http\Repositories\UserRepositoryI;
use App\Http\Repositories\UserRepositoryImpl;
use App\Http\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(UserService::class, UserService::class);
        $this->app->bind(UserRepositoryI::class, UserRepositoryImpl::class);
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
