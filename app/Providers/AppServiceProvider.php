<?php

namespace App\Providers;

use App\Http\Service\Impl\AuthServiceImpl;
use App\Http\Service\AuthService;
use App\Http\Service\Impl\TaskServiceImpl;
use App\Http\Service\Impl\UserServiceImpl;
use App\Http\Service\TaskService;
use App\Http\Service\UserService;
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
        //
        $this->app->bind(AuthService::class, AuthServiceImpl::class);
        $this->app->bind(UserService::class, UserServiceImpl::class);
        $this->app->bind(TaskService::class, TaskServiceImpl::class);
    }
}
