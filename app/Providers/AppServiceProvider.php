<?php

namespace App\Providers;

use App\Repository\extend\ICategoryRepo as ExtendICategoryRepo;
use App\Repository\extend\IProductRepo as ExtendIProductRepo;
use App\Repository\extend\IUserRepo;
use App\Repository\impl\CategoryRepo;
use App\Service\extend\IServiceProduct as ExtendIServiceProduct;
use App\Service\impl\ProductService as ImplProductService;
use Illuminate\Support\ServiceProvider;
use App\Repository\impl\ProductRepo as ImplProductRepo;
use App\Repository\impl\UserRepo;
use App\Service\extend\IServiceCategory;
use App\Service\extend\IServiceUser;
use App\Service\impl\CategoryService;
use App\Service\impl\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(ExtendIProductRepo::class, ImplProductRepo::class);
        $this->app->bind(ExtendIServiceProduct::class, ImplProductService::class);

        $this->app->bind(ExtendICategoryRepo::class, CategoryRepo::class);
        $this->app->bind(IServiceCategory::class, CategoryService::class);

        $this->app->bind(IUserRepo::class, UserRepo::class);
        $this->app->bind(IServiceUser::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
