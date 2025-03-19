<?php

namespace App\Providers;

use App\Repository\extend\ICartRepo;
use App\Repository\extend\ICategoryRepo as ExtendICategoryRepo;
use App\Repository\extend\IDetailOrderRepo;
use App\Repository\extend\INotifiRepo;
use App\Repository\extend\IOrderRepo;
use App\Repository\extend\IProductRepo as ExtendIProductRepo;
use App\Repository\extend\ISaleReportRepo;
use App\Repository\extend\IUserRepo;
use App\Repository\impl\CartRepo;
use App\Repository\impl\CategoryRepo;
use App\Repository\impl\DetailOrderRepo;
use App\Repository\impl\NotifiRepo;
use App\Repository\impl\OrderRepo;
use App\Service\extend\IServiceProduct as ExtendIServiceProduct;
use App\Service\impl\ProductService as ImplProductService;
use Illuminate\Support\ServiceProvider;
use App\Repository\impl\ProductRepo as ImplProductRepo;
use App\Repository\impl\SaleReportRepo;
use App\Repository\impl\UserRepo;
use App\Service\extend\IServiceCart;
use App\Service\extend\IServiceCategory;
use App\Service\extend\IServiceDetailOrder;
use App\Service\extend\IServiceNotifi;
use App\Service\extend\IServiceOrder;
use App\Service\extend\IServiceSaleReport;
use App\Service\extend\IServiceUser;
use App\Service\impl\CartService;
use App\Service\impl\CategoryService;
use App\Service\impl\DetailOrderService;
use App\Service\impl\NotifiService;
use App\Service\impl\OrderService;
use App\Service\impl\SaleReportService;
use App\Service\impl\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

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

        $this->app->bind(ICartRepo::class, CartRepo::class);
        $this->app->bind(IServiceCart::class, CartService::class);

        $this->app->bind(IOrderRepo::class, OrderRepo::class);
        $this->app->bind(IServiceOrder::class, OrderService::class);

        $this->app->bind(IDetailOrderRepo::class, DetailOrderRepo::class);
        $this->app->bind(IServiceDetailOrder::class, DetailOrderService::class);

        $this->app->bind(ISaleReportRepo::class, SaleReportRepo::class);
        $this->app->bind(IServiceSaleReport::class, SaleReportService::class);

        $this->app->bind(INotifiRepo::class, NotifiRepo::class);
        $this->app->bind(IServiceNotifi::class, NotifiService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        Carbon::setTestNow(now());
        Date::use(Carbon::class);
    }
}
