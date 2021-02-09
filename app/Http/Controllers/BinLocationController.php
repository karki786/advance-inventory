<?php

namespace App\Http\Controllers;

use App\Http\Requests\BinLocationRequest;
use CodedCell\Repository\Warehouse\WarehouseInterface;
use CodedCell\Traits\PaginateTrait;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BinLocationController extends Controller
{
    use PaginateTrait;

    public function __construct(WarehouseInterface $warehouse)
    {
        $this->warehouse = $warehouse;
        $this->middleware('auth');
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
    public function create(Request $request)
    {
        $warehouse = $request->warehouseid;
        $warehouse = $this->warehouse->getWarehouse($warehouse);
        return view('warehouse.create_binlocation')->with(compact('warehouse'));
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $model = $this->warehouse->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BinLocationRequest $form)
    {
        $binLocation = $this->warehouse->saveWarehouseLocation($request->except(['_token']));
        $request->session()->flash('info', "Bin Location {$binLocation->binCode} Added, You can add Another if you like");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locations = $this->warehouse->getWarehouseLocations($id);
        return view('warehouse.view_binlocations')->with(compact('locations','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warehouse = $this->warehouse->getWarehouseFromLocation($id);
        $bin = $this->warehouse->getWarehouseLocation($id);
        return view('warehouse.create_binlocation')->with(compact('warehouse', 'bin'));
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
        $this->warehouse->updateWarehouseLocation($id, $request->except(['_token']));
        $url = action('BinLocationController@show', $request->whsId);
        $request->session()->flash('info', "Bin Location has been updated View other warehouse bin locations <a href='{$url}'>Click Here</a>");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->warehouse->removeWarehouseLocation($id);
    }
}
