<?php

namespace App\Providers;

use App\Interfaces\Admins\{AuthRepositoryInterface as AdminsAuthRepositoryInterface, BrandRepositoryInterface as AdminsBrandsRepositoryInterface, CategoryRepositoryInterface as AdminsCategoryRepositoryInterface, DashboardRepositoryInterface, FileRepositoryInterface as AdminsFileRepositoryInterface, ItemRepositoryInterface as AdminsItemRepositoryInterface, OrderRepositoryInterface as AdminsOrderRepositoryInterface};
use App\Interfaces\Users\AuthRepositoryInterface;
use App\Repositories\Admins\{AuthRepository as AdminsAuthRepository, BrandRepository as AdminsBrandRepository, CategoryRepository as AdminsCategoryRepository, DashboardRepository, FileRepository as AdminsFileRepository, ItemRepository as AdminsItemsRepository, OrderRepository as AdminsOrderRepository};
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
        $this->app->bind(AdminsBrandsRepositoryInterface::class, AdminsBrandRepository::class);
        $this->app->bind(AdminsCategoryRepositoryInterface::class, AdminsCategoryRepository::class);
        $this->app->bind(AdminsItemRepositoryInterface::class, AdminsItemsRepository::class);
        $this->app->bind(AdminsFileRepositoryInterface::class, AdminsFileRepository::class);
        $this->app->bind(AdminsOrderRepositoryInterface::class, AdminsOrderRepository::class);
        $this->app->bind(DashboardRepositoryInterface::class, DashboardRepository::class);

    }

    public function provides(): array
    {
        return [
            // users
            AuthRepositoryInterface::class,

            // admins
            AdminsAuthRepositoryInterface::class,
            AdminsBrandsRepositoryInterface::class,
            AdminsCategoryRepositoryInterface::class,
            AdminsItemRepositoryInterface::class,
            AdminsFileRepositoryInterface::class,
            AdminsOrderRepositoryInterface::class,
            DashboardRepositoryInterface::class,

        ];
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {}
}
