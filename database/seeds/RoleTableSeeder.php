<?php

use App\Role;
use Illuminate\Database\Seeder;
use App\ModulePermission;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::loginUsingId(1);
        //DB::table('roles')->truncate();
        Role::create([
            'id' => 1,
            'name' => 'Root',
            'description' => 'Use this account with extreme caution. When using this account it is possible to cause irreversible damage to the system.'
        ]);

        Role::create([
            'id' => 2,
            'name' => 'Administrator',
            'description' => 'Full access to create, edit, Delete Stock Items, Users and Departments'
        ]);

        Role::create([
            'id' => 3,
            'name' => 'Dispatcher',
            'description' => 'Ability to Dispach and Restock Items can also delete Dispatches and Restocks but not users and departments'
        ]);

        Role::create([
            'id' => 4,
            'name' => 'Requisitor',
            'description' => 'Can Raise requisitions and restock their purchase orders'
        ]);

        Role::create([
            'id' => 5,
            'name' => 'Purchaser',
            'description' => 'Responsible for procurement'
        ]);
        Role::create([
            'id' => 6,
            'name' => 'Office',
            'description' => 'Responsible for Office Dispatches'
        ]);

        Role::create([
            'id' => 7,
            'name' => 'Warehouse',
            'description' => 'Responsible for Warehouse Managment'
        ]);

        Role::create([
            'id' => 8,
            'name' => 'DeliveryManager',
            'description' => 'Responsible for Delivery Managment'
        ]);

        $models = array(
            array('text' => 'Receipt', 'id' => 'Receipt'),
            array('text' => 'Warehouse', 'id' => 'Warehouse'),
            array('text' => 'ProductCategory', 'id' => 'ProductCategory'),
            array('text' => 'UserRoles', 'id' => 'UserRoles'),
            array('text' => 'User', 'id' => 'User'),
            array('text' => 'Supplier', 'id' => 'Supplier'),
            array('text' => 'Staff', 'id' => 'Staff'),
            array('text' => 'Setting', 'id' => 'Setting'),
            array('text' => 'Restock', 'id' => 'Restock'),
            array('text' => 'PurchaseOrder', 'id' => 'PurchaseOrder'),
            array('text' => 'Product', 'id' => 'Product'),
            array('text' => 'Message', 'id' => 'Message'),
            array('text' => 'Invoice', 'id' => 'Invoice'),
            array('text' => 'Dispatch', 'id' => 'Dispatch'),
            array('text' => 'Department', 'id' => 'Department'),
            array('text' => 'Customer', 'id' => 'Customer'),
            array('text' => 'Company', 'id' => 'Company'),
            array('text' => 'SalesOrder', 'id' => 'SalesOrder'),
            array('text' => 'Currency', 'id' => 'Currency'),
            array('text' => 'InvoicePayment', 'id' => 'InvoicePayment'),
            array('text' => 'PurchaseOrder', 'id' => 'PurchaseOrder'),
            array('text' => 'Company', 'id' => 'Company'),
        );


        foreach ($models as $model) {
            ModulePermission::updateOrCreate(
                [
                    'roleId' => 1,
                    'model' => $model['text']
                ],
                [
                    'canCreate' => 1,
                    'canGlance' => 1,
                    'canView' => 1,
                    'canUpdate' => 1,
                    'canDelete' => 1,
                ]
            );
        }
    }
}
