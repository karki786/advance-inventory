<?php

namespace App\Providers;

use App\Dispatch;
use App\Observers\DispatchObserver;
use App\Observers\InvoiceItemObserver;
use App\Observers\ProductLocationObserver;
use App\Observers\ProductObserver;
use App\Observers\ProductPhotoObserver;
use App\Observers\PurchaseOrderItemObserver;
use App\Observers\RestockObserver;
use App\Observers\SalesOrderItemObserver;
use App\Observers\SalesOrderObserver;
use App\Product;
use App\ProductLocation;
use App\ProductPhotos;
use App\PurchaseOrder;
use App\PurchaseOrderItem;
use App\Restock;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\InvoiceItem;
use App\Invoice;
use App\SalesOrder;
use App\SalesOrderItem;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);
        InvoiceItem::observe(InvoiceItemObserver::class);
        Invoice::observe(InvoiceObserver::class);
        Product::observe(ProductObserver::class);
        ProductLocation::observe(ProductLocationObserver::class);
        SalesOrder::observe(SalesOrderObserver::class);
        SalesOrderItem::observe(SalesOrderItemObserver::class);
        ProductPhotos::observe(ProductPhotoObserver::class);
        Dispatch::observe(DispatchObserver::class);
        PurchaseOrderItem::observe(PurchaseOrderItemObserver::class);
        Restock::observe(RestockObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }

    }
}
