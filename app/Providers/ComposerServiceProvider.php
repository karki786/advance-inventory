<?php namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $settings = array(
            'layouts.master',
            'dashboard.*',
            'settings.*',
            'currency.*',
            'purchaseorder.formats.*',
            'purchaseorder.create_purchaseorder',
            'products.create_product',
            'invoice.*',
            'customer.create_customer',
            'subscription.*',
            'salesorder.*',
            'staff.form'
        );

        $pagination = array(
            'products.tableview'
        );

        $invoicing = array(
            'invoice.create_invoice',
            'pos.create_sale',
            'invoice.view_invoices',
            'salesorder.create_salesorder',
            'sales.create_sale',
            'subscription.create_subscription'
        );
        View::composer('warehouse.create_warehouse', 'App\Http\ViewComposers\SidebarComposer');
        View::composer('layouts.sidebar', 'App\Http\ViewComposers\WarehouseComposer');
        View::composer('dashboard.*', 'App\Http\ViewComposers\SidebarComposer');
        View::composer('dispatches.create_dispatch', 'App\Http\ViewComposers\DispatchesComposer'); // Why isnt this working
        View::composer('internalrequest.form', 'App\Http\ViewComposers\DispatchesComposer'); // Why isnt this working
        //View::composer('products.tableview', 'App\Http\ViewComposers\ProductsComposer');
        View::composer('products.create_product', 'App\Http\ViewComposers\AddProductsComposer');
        View::composer('purchaseorder.restockfrompurchaseorder', 'App\Http\ViewComposers\AddProductsComposer');
        View::composer('restocks.create_restock', 'App\Http\ViewComposers\RestocksComposer');
        View::composer('users.createupdateuser', 'App\Http\ViewComposers\UserFormComposer');
        View::composer('staff.createupdateuser', 'App\Http\ViewComposers\StaffFormComposer');
        //View::composer('*', 'App\Http\ViewComposers\SortComposer');
        View::composer('layouts.partials.email', 'App\Http\ViewComposers\EmailsComposer');
        View::composer('delivery.create_delivery', 'App\Http\ViewComposers\DeliveryComposer');
        View::composer('subscription.create_subscription', 'App\Http\ViewComposers\SubscriptionComposer');
        View::composer($settings, 'App\Http\ViewComposers\SettingsComposer');

        View::composer('purchaseorder.create_purchaseorder', 'App\Http\ViewComposers\PurchaseOrderComposer');

        View::composer('invoice.newinvoice', 'App\Http\ViewComposers\PurchaseOrderComposer');
        View::composer('purchaseorder.editpurchaseorder', 'App\Http\ViewComposers\PurchaseOrderComposer');
        View::composer('purchaseorder.view_purchaseorders', 'App\Http\ViewComposers\PurchaseOrderComposer');
        View::composer('customer.form', 'App\Http\ViewComposers\CustomerComposer');
        View::composer('purchaserequest.create_purchaserequest', 'App\Http\ViewComposers\PurchaseRequestComposer');
        View::composer('purchaserequest.view_purchaseorders', 'App\Http\ViewComposers\PurchaseRequestComposer');
        View::composer('currency.create_view_edit_currency', 'App\Http\ViewComposers\CurrencyRequestComposer');

        //Sales Order Composer
        View::composer($invoicing, 'App\Http\ViewComposers\InvoiceComposer');
        View::composer('payment.create_payment', 'App\Http\ViewComposers\PaymentsComposer');
        View::composer('payment.create_payment_multiple', 'App\Http\ViewComposers\PaymentsComposer');
        View::composer('salesorder.view_salesorders', 'App\Http\ViewComposers\SalesOrderComposer');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
