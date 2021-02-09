<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseFormRequest;
use App\ProductLocation;
use App\Warehouse;
use Carbon\Carbon;
use CodedCell\Repository\Warehouse\WarehouseInterface;
use CodedCell\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Excel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;

class WarehouseController extends Controller
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
        $this->authorize('glance', Warehouse::class);
        $warehouses = $this->warehouse->getWarehouses();
        return view('warehouse.view_warehouses')->with(compact('warehouses'));
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $model = $this->warehouse->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    public function tableDetails(Request $request)
    {
        $paginate = boolval($request->paginate);
        $model = $this->warehouse->paginateDetails($request->id, 20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Warehouse::class);
        return view('warehouse.create_warehouse');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, WarehouseFormRequest $form)
    {
        $this->authorize('create', Warehouse::class);
        $warehouse = $this->warehouse->saveWarehouse($request->except(['_token']));
        $request->session()->flash('info', 'Warehouse Added Please start adding bin Locations');
        return redirect()->action('BinLocationController@create', array('warehouseid' => $warehouse->id));
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locations = $this->warehouse->getProductsInWarehouse($id);
        $this->authorize('view', $locations->first()->warehouse);
        return view('warehouse.view_productlocations')->with(compact('locations', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warehouse = $this->warehouse->getWarehouse($id);
        $this->authorize('view', $warehouse);
        return view('warehouse.create_warehouse')->with(compact('warehouse'));
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
        $warehouse = $this->warehouse->updateWarehouse($id, $request->except(['_token']));
        $url = action('BinLocationController@create', array('warehouseid' => $id));
        $request->session()->flash('info', "Warehouse has been updated, to add a bin Location <a href='{$url}'>Click Here</a> ");
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
        return $this->warehouse->removeWarehouse($id);
    }

    public function export(Request $request)
    {
        $format = $request->type;
        $filename = Carbon::now()->format('Ymd_') . "WarehouseAllocationReport";
        $file = Excel::create($filename, function ($excel) {

            $excel->sheet('Warehouse Locations', function ($sheet) {
                $sheet->setfitToPage(0);
                $sheet->setfitToWidth(0);
                $sheet->setfitToHeight(0);
                $sheet->freezeFirstRowAndColumn();
                $sheet->setOrientation('landscape');
                $warehouses = $this->warehouse->getWarehouses();
                $sheet->cell('A1', function ($cell) {

                    $cell->setAlignment('center');

                });
                $sheet->loadView('reports.warehouse.warehouse')->with(compact('warehouses'));

            });
            /*
                        $excel->sheet('Storage Locations and Products', function ($sheet) {
                            $sheet->setfitToPage(0);
                            $sheet->setfitToWidth(0);
                            $sheet->setfitToHeight(0);
                            $sheet->freezeFirstRowAndColumn();
                            $sheet->setOrientation('potrait');
                            $warehouses = $this->warehouse->getWarehouses();
                            $sheet->loadView('reports.warehouse.warehouse_utilization')->with(compact('warehouses'));

                        });
            */

        });

        if ($format == "email") {
            $email = $request->email;
            $save_details = $file->store('xlsx');
            $message = "Please find attached a list of products and their levels";
            $reportName = "Product Levels Report";
            $variables = array(
                'content' => $message,
                'reportName' => $reportName,
                'staff' => "Dennis Wanyoike",
                'action' => 'Blah'

            );
            Mail::send('emails.report_view', $variables, function ($message) use ($save_details, $email) {
                $message->to($email)->subject('Products And Their Levels in Stock Control System');
                $message->attach($save_details['full']);
            });
            return Response::json(['ok' => 'ok']);
        } else {
            $file->download($format);
        }
    }
}
