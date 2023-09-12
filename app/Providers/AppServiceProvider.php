<?php

namespace App\Providers;

use App\Repositories\CarRepository;
use App\Repositories\CarrgoRepository;
use App\Repositories\ChatRepository;
use App\Repositories\Interfaces\CarRepositoryInterface;
use App\Repositories\Interfaces\CarrgoRepositoryInterface;
use App\Repositories\Interfaces\ChatRepositoryInterface;
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
        $this->app->bind(CarrgoRepositoryInterface::class , CarrgoRepository::class);
        $this->app->bind(ChatRepositoryInterface::class , ChatRepository::class);
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
