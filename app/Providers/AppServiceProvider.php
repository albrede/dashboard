<?php

namespace App\Providers;

use App\Services\NestJsAuthUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse as CustomLoginResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(NestJsAuthUser::class, fn() => new NestJsAuthUser());
        $this->app->singleton(
            LoginResponseContract::class,
            CustomLoginResponse::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Add this to force logging to a file


    }
}
