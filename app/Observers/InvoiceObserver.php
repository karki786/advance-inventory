<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 20/May/2017
 * Time: 6:01 PM
 */

namespace App\Observers;

use App\Product;
use App\Invoice;
use App\InvoiceItem;
use Facades\CodedCell\Classes\InventoryWatcher;
use Hashids\Hashids;

class InvoiceObserver
{

    public function saving(Invoice $invoice)
    {
        $user = Auth::user();
        $invoice->salesPersonId = $user->id;
        $invoice->salesPersonText = $user->name;
        $customer = Customer::find($invoice->customerId);
        $invoice->customerText = $customer->companyName;
    }

    /**
     * Listen to the Invoice created event.
     *
     * @param  Invoice $sales
     * @return void
     */
    public function created(Invoice $sales)
    {

    }

    /**
     * Listen to the Invoice deleting event.
     *
     * @param  Invoice $sales
     * @return void
     */
    public function deleting(Invoice $sales)
    {
        //
    }

    /**
     * Listen to the Invoice deleting event.
     *
     * @param  Invoice $sales
     * @return void
     */
    public function creating(Invoice $sales)
    {
        //
    }

    /**
     * Listen to the Invoice deleting event.
     *
     * @param  Invoice $sales
     * @return void
     */
    public function updating(Invoice $sales)
    {

    }

    /**
     * Listen to the Invoice deleting event.
     *
     * @param  Invoice $sales
     * @return void
     */
    public function updated(Invoice $sales)
    {
        //
    }
}