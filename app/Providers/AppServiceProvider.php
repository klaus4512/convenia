<?php

namespace App\Providers;

use App\Domain\Repositories\EmployeeRepository;
use App\Infrastructure\Repositories\EmployeeEloquentWithCacheRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(EmployeeRepository::class, EmployeeEloquentWithCacheRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Passport::enablePasswordGrant();
    }
}
