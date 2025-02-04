<?php

namespace App\Providers;

use App\Repository\extend\ICategoryRepo as ExtendICategoryRepo;
use App\Repository\extend\IProductRepo as ExtendIProductRepo;
use App\Repository\impl\CategoryRepo;
use App\Service\extend\IServiceProduct as ExtendIServiceProduct;
use App\Service\impl\ProductService as ImplProductService;
use Illuminate\Support\ServiceProvider;
use App\Repository\impl\ProductRepo as ImplProductRepo;
use App\Service\extend\IServiceCategory;
use App\Service\impl\CategoryService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ExtendIProductRepo::class, ImplProductRepo::class);
        $this->app->bind(ExtendIServiceProduct::class, ImplProductService::class);

        $this->app->bind(ExtendICategoryRepo::class, CategoryRepo::class);
        $this->app->bind(IServiceCategory::class, CategoryService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
