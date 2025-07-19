<?php

namespace App\Providers;

use App\Interfaces\Users\AuthRepositoryInterface;
use App\Repositories\Users\AuthRepository;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    }

    public function provides(): array
    {
        return [
            AuthRepositoryInterface::class,
        ];
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {}
}
