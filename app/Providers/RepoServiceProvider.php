<?php

namespace App\Providers;

use App\Interfaces\Admins\AuthRepositoryInterface as AdminsAuthRepositoryInterface;
use App\Interfaces\Users\AuthRepositoryInterface;
use App\Repositories\Admins\AuthRepository as AdminsAuthRepository;
use App\Repositories\Users\AuthRepository;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // users
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);

        // admins
        $this->app->bind(AdminsAuthRepositoryInterface::class, AdminsAuthRepository::class);
    }

    public function provides(): array
    {
        return [
            // users
            AuthRepositoryInterface::class,

            // admins
            AdminsAuthRepositoryInterface::class,
        ];
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {}
}
