<?php

namespace App\Http\Controllers\Api;

use App\PurchaseOrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CodedCell\Repository\Product\ProductInterface;
use Facades\CodedCell\Classes\InventoryWatcher;
use App\Currency;
use Carbon\Carbon;

class PurchaseOrderController extends Controller
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
        $data = $request->all();
        $data['amount'] = $data['quantity'];
        $data['unitCost'] = $data['sellingPrice'];
        $data['productId'] = $data['prod_id'];
        $data['lpoId'] = $data['invoiceId'];
        unset($data['quantity']);
        unset($data['invoiceId']);
        unset($data['sellingPrice']);
        unset($data['binLocation']);
        unset($data['convertedPrice']);
        unset($data['salesOrderId']);
        unset($data['prod_id']);
        unset($data['locationHash']);
        unset($data['price']);
        return PurchaseOrderItem::create($data);
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
        $item = $request->all();
        $item['amount'] = $item['quantity'];
        $item['unitCost'] = $item['sellingPrice'];
        $item = array_except($item, ['sellingPrice', 'quantity', 'binLocation', 'convertedPrice', 'prod_id', 'locationHash', 'price']);

        PurchaseOrderItem::find($id)->update($item);
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
        return PurchaseOrderItem::destroy($id);
    }
}
