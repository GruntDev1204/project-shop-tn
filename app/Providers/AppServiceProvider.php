<?php

namespace App\Providers;

use App\Repository\extend\IProductRepo as ExtendIProductRepo;
use App\Service\extend\IServiceProduct as ExtendIServiceProduct;
use App\Service\impl\ProductService as ImplProductService;
use Illuminate\Support\ServiceProvider;
use App\Repository\impl\ProductRepo as ImplProductRepo;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ExtendIProductRepo::class, ImplProductRepo::class);
        $this->app->bind(ExtendIServiceProduct::class, ImplProductService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
