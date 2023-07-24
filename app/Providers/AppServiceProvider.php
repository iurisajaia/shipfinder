<?php

namespace App\Providers;

use App\Repositories\CarRepository;
use App\Repositories\Interfaces\CarRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\DriverRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\DriverRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class , UserRepository::class);
        $this->app->bind(DriverRepositoryInterface::class , DriverRepository::class);
        $this->app->bind(CarRepositoryInterface::class , CarRepository::class);
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
