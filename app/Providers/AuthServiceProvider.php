<?php

namespace App\Providers;

use App\Currency;
use App\Policies\CurrencyPolicy;
use App\Policies\PurchaseOrderPolicy;
use App\Policies\SalesOrderPolicy;
use App\Product;
use App\Customer;
use App\ProductCategory;
use App\InvoicePayment;
use App\Invoice;
use App\Department;
use App\Dispatch;
use App\Payment;
use App\PurchaseOrder;
use App\Receipt;
use App\Restock;
use App\SalesOrder;
use App\Setting;
use App\Staff;
use App\Supplier;
use App\User;
use App\Warehouse;
use App\Policies\CustomerPolicy;
use App\Policies\ProductCategoryPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\DispatchPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\PaymentPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ReceiptPolicy;
use App\Policies\RestockPolicy;
use App\Policies\SettingsPolicy;
use App\Policies\StaffPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UserPolicy;
use App\Policies\WarehousePolicy;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        Product::class => ProductPolicy::class,
        ProductCategory::class => ProductCategoryPolicy::class,
        Customer::class => CustomerPolicy::class,
        Department::class => DepartmentPolicy::class,
        Dispatch::class => DispatchPolicy::class,
        Invoice::class => InvoicePolicy::class,
        Payment::class => PaymentPolicy::class,
        Receipt::class => ReceiptPolicy::class,
        Restock::class => RestockPolicy::class,
        Setting::class => SettingsPolicy::class,
        InvoicePayment::class => PaymentPolicy::class,
        Staff::class => StaffPolicy::class,
        Supplier::class => SupplierPolicy::class,
        User::class => UserPolicy::class,
        Warehouse::class => WarehousePolicy::class,
        PurchaseOrder::class => PurchaseOrderPolicy::class,
        SalesOrder::class => SalesOrderPolicy::class,
        Currency::class => CurrencyPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
