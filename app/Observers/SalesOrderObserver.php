<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 20/May/2017
 * Time: 6:01 PM
 */

namespace App\Observers;

use App\Customer;
use App\SalesOrder;
use Auth;

class SalesOrderObserver
{

    public function saving(SalesOrder $sales)
    {
        $user = Auth::user();
        $sales->salesPersonId = $user->id;
        $sales->salesPersonText = $user->name;
        $customer = Customer::find($sales->customerId);
        $sales->customerText = $customer->companyName;
    }

    /**
     * Listen to the SalesOrder created event.
     *
     * @param  SalesOrder $sales
     * @return void
     */
    public function created(SalesOrder $sales)
    {

    }

    /**
     * Listen to the SalesOrder deleting event.
     *
     * @param  SalesOrder $sales
     * @return void
     */
    public function deleting(SalesOrder $sales)
    {
        //
    }

    /**
     * Listen to the SalesOrder deleting event.
     *
     * @param  SalesOrder $sales
     * @return void
     */
    public function creating(SalesOrder $sales)
    {
        //
    }

    /**
     * Listen to the SalesOrder deleting event.
     *
     * @param  SalesOrder $sales
     * @return void
     */
    public function updating(SalesOrder $sales)
    {

    }

    /**
     * Listen to the SalesOrder deleting event.
     *
     * @param  SalesOrder $sales
     * @return void
     */
    public function updated(SalesOrder $sales)
    {
        //
    }
}