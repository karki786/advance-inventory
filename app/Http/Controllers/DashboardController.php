<?php namespace App\Http\Controllers;

use App\Http\Requests;
use CodedCell\Repository\Category\CategoryInterface;
use CodedCell\Repository\Department\DepartmentInterface;
use CodedCell\Repository\Dispatch\DispatchInterface;
use CodedCell\Repository\Product\ProductInterface;
use CodedCell\Repository\Restock\RestockInterface;
use CodedCell\Repository\Supplier\SupplierInterface;
use CodedCell\Repository\User\UserInterface;
use CodedCell\Repository\Warehouse\WarehouseInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{



    public function __construct(
        ProductInterface $product,
        UserInterface $user,
        RestockInterface $restock,
        DepartmentInterface $department,
        SupplierInterface $supplier,
        DispatchInterface $dispatch,
        CategoryInterface $category,
        WarehouseInterface $warehouse
    )
    {
        $this->product = $product;
        $this->dispatch = $dispatch;
        $this->user = $user;
        $this->restock = $restock;
        $this->department = $department;
        $this->supplier = $supplier;
        $this->category = $category;
        $this->warehouse = $warehouse;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $displayMessage = $request->session()->pull('displayMessage', 'no');
        $productCount = $this->product->productsCount();
        $stockWorth = $this->product->all(array())->sum('unitCost');
        $departmentCount = $this->department->getDepartmentCount();
        $userCount = $this->user->userCount();
        $supplierCount = $this->supplier->getSuppliersCount();
        $supplierAmountReport = $this->supplier->suppliersReportAmount();
        $data = json_encode($supplierAmountReport);
        $supplierAmountReport = str_replace("'", "", $data);
        $dispatchTrend = $this->dispatch->getDailyDispatchReport();
        $restockTrend = $this->restock->getDailyRestockGraph();
        $warehouseUsage = $this->warehouse->getWarehouseUtilization();
        $totalRestockCost = $this->restock->getCost(0);
        $totalDispatchCost = $this->dispatch->getCost(0);
        $lowStock = $this->product->getLowStockCount();
        $printedPages = 0;
        $dispatchCount = $this->dispatch->getDispatchCount();
        $restockCount = $this->restock->getRestocksCount();
        $categoryCount = $this->category->getCategoryCount();
        if ($printedPages) {
            $printedPages = $printedPages->pages;
        }
        return View('dashboard/index')->with(compact('warehouseUsage', 'stockWorth', 'categoryCount', 'restockCount', 'dispatchCount', 'printedPages', 'productCount', 'departmentCount', 'userCount', 'supplierCount', 'supplierAmountReport', 'dispatchTrend', 'totalRestockCost', 'totalDispatchCost', 'lowStock', 'displayMessage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
