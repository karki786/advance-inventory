<?php

namespace App\Http\Controllers;

use App\ReceiptItem;
use CodedCell\Repository\Receipt\ReceiptInterface;
use Illuminate\Http\Request;
use App\Company;
use Auth;

class ReceiptController extends Controller
{
    public function __construct(ReceiptInterface $receiptInterface)
    {
        $this->receipt = $receiptInterface;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receipts = $this->receipt->all();

        return view('pos.view_sales')->with(compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companySettings = Company::find(Auth::user()->companyId);
        $prevCurr = $companySettings->defaultCurrency;
        return view('pos.create_sale')->with(compact('prevCurr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(array('currencyTypeText' => $request->currency));
        $receipt = $request->except(['sales', 'products', 'generatePackingSlip', 'emailCustomer', 'remark', 'currency', 'saleType', 'barcode']);

        $receipt = $this->receipt->create($receipt, json_decode($request->sales));
        return redirect()->action('ReceiptController@show', array('id' => $receipt->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receipt = $this->receipt->find($id);
        return view('pos.view_sale')->with(compact('receipt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $receipt = $this->receipt->find($id);
        $sales = $receipt->items;
        $contacts = [];
        $delete_url = url('receipt/stock/delete');
        $prevCurr = $receipt->currencyTypeText;
        return view('pos.create_sale')->with(compact('receipt', 'sales', 'contacts', 'delete_url', 'prevCurr'));
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
        $request->merge(array('currencyTypeText' => $request->currency));
        $receipt = $request->except(['sales', 'products', 'generatePackingSlip', 'emailCustomer', 'remark', 'currency', 'saleType', 'barcode']);
        $this->receipt->update($receipt, json_decode($request->sales), $id);
        return redirect()->action('ReceiptController@show', array('id' => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->receipt->delete($id);
        return back();
    }

    public function destroyItem($id)
    {
        $receiptId = ReceiptItem::find($id)->receiptId;
        ReceiptItem::destroy($id);
        $receipt = $this->receipt->find($receiptId);
        $sales = $receipt->items;
        return array('deleted' => true, 'sales' => $sales);
    }
}
