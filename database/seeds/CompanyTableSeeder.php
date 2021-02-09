<?php

use App\Company;
use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->truncate();
        $faker = Faker\Factory::create();
        $company = Company::create(array(
            'companyName' => 'ACME',
            'city' => 'Nairobi',
            'country' => 'Kenya',
            'defaultCurrency' => 'KES',
            'purchaseOrderFormat' => 'sales_order_1',
            'lpoNumberingFormat' => 'LPO-{$year}/{$month}/{$date}/{$lpoNumber}',
            'salesOrderNumberingFormat' => 'QT-{$year}-{$month}/{$quoteNumber}',
            'invoiceNumberingFormat' => 'IN-{$year}-{$month}-{$invoiceNumber}',
            'receiptNumberingFormat' => 'RCT-{$year}-{$month}-{$receiptNumber}'
        ));
    }
}
