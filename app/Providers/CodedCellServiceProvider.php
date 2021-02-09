<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CodedCellServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $models = array(
            'Receipt',
            'Warehouse',
            'Request',
            'Category',
            'UserRoles',
            'User',
            'Supplier',
            'Staff',
            'Settings',
            'Restock',
            'PurchaseOrder',
            'Product',
            'Model',
            'Message',
            'Invoice',
            'Dispatch',
            'Department',
            'Customer',
            'Category',
            'Company',
            'SalesOrder',
            'Currency',
            'Payment',
            'Language',
            'Translation'

        );
        foreach ($models as $model) {
            $this->app->bind("CodedCell\\Repository\\{$model}\\{$model}Interface", "CodedCell\\Repository\\{$model}\\{$model}Entity");
        }

    }

}
