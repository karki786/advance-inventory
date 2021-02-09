<?php

use App\Company;
use App\Country;
use App\Department;
use App\Dispatch;
use App\Product;
use App\ProductCategory;
use App\Restock;
use App\Role;
use App\Staff;
use App\Supplier;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call("CompanyTableSeeder");
        $this->call('UserTableSeeder');
        $this->call('CategoryTableSeeder');
        $this->call("DepartmentTableSeeder");
        $this->call("StaffTableSeeder");
        $this->call('WarehouseSeeder');
        $this->call('ProductTableSeeder');
        $this->call('SupplierTableSeeder');
        $this->call('RestockTableSeeder');
        $this->call('DispatchTableSeeder');
        $this->call('RoleTableSeeder');
        $this->call('CountryTableSeeder');
        $this->call('PurchaseOrdersSeeder');
        $this->call('CustomerTableSeeder');
        $this->call('SalesOrderSeeder');
        $this->call('InvoiceTableSeeder');
        $this->call('PaymentTableSeeder');

    }

}



