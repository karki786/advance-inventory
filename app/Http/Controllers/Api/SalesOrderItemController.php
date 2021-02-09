<?php

namespace App\Http\Controllers\Api;

use App\SalesOrder;
use App\SalesOrderItem;
use CodedCell\Repository\Product\ProductInterface;
use Facades\CodedCell\Classes\InventoryWatcher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Currency;
use Carbon\Carbon;

class SalesOrderItemController extends Controller
{
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('price', 'has_error', 'error');
        $data['productId'] = $data['prod_id'];
        $data['salesOrderId'] = $data['invoiceId'];
        unset($data['prod_id']);
        unset($data['invoiceId']);
        return SalesOrderItem::create(array_except($data, 'prod_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $params = explode('-', $id);
        $product = $this->product->getProductForAjaxGrid($params[0], $params[1]);
        //Currency conversion
        $currencyConv = Currency::where('startDate', '<=', Carbon::today())
            ->where('endDate', '>=', Carbon::today())
            ->where('currency', '=', $request->curr)
            ->first();
        if (count($currencyConv) > 0) {
            $product['convertedPrice'] = $currencyConv->amount * $product['sellingPrice'];
            $product['convertedRate'] = $currencyConv->amount;
        } else {
            $product['convertedPrice'] = 1 * $product['sellingPrice'];
            $product['convertedRate'] = 1;
        }
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('price', 'has_error', 'error');
        $data['productId'] = $data['prod_id'];
        //  $data['salesOrderId'] = $data['invoiceId'];
        unset($data['prod_id']);
        unset($data['invoiceId']);
        unset($data['product']);
        SalesOrderItem::find($id)->update($data);
        return array('ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = SalesOrderItem::findOrFail($id);

        InventoryWatcher::decreaseProductMagic($item->productId, $item->quantity, $item->locationHas);
        return SalesOrderItem::destroy($id);

    }

    public function validateInventory(Request $request)
    {
        $params = explode('-', $request->productId);
        if (isset($params[1])) {
            if ($params[1] == 'N') {
                return InventoryWatcher::validate($params[0], $request->quantity);
            }
        }
        if (isset($params[1])) {
            return InventoryWatcher::validateMultipleLocation($params[0], $request->quantity);
        } else {
            return InventoryWatcher::validate($params[0], $request->quantity);
        }
    }
}
