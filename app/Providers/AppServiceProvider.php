<?php

namespace App\Providers;

use App\Domain\Repositories\EmployeeFileRepository;
use App\Domain\Repositories\EmployeeRepository;
use App\Infrastructure\Repositories\EmployeeEloquentWithCacheRepository;
use App\Infrastructure\Repositories\EmployeeFileLocalRepository;
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
        $this->app->bind(EmployeeFileRepository::class, EmployeeFileLocalRepository::class);
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
