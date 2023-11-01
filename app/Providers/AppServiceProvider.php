<?php

namespace App\Providers;

use App\Repositories\CarRepository;
use App\Repositories\CargoRepository;
use App\Repositories\ChatRepository;
use App\Repositories\Interfaces\CarRepositoryInterface;
use App\Repositories\Interfaces\CargoRepositoryInterface;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\TrailerRepositoryInterface;
use App\Repositories\MediaRepository;
use App\Repositories\RoleRepository;
use App\Repositories\TrailerRepository;
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
        $this->app->bind(CargoRepositoryInterface::class , CargoRepository::class);
        $this->app->bind(ChatRepositoryInterface::class , ChatRepository::class);
        $this->app->bind(RoleRepositoryInterface::class , RoleRepository::class);
        $this->app->bind(TrailerRepositoryInterface::class , TrailerRepository::class);
        $this->app->bind(MediaRepositoryInterface::class , MediaRepository::class);
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
