<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Supplier;
use Carbon;
use CodedCell\Repository\Supplier\SupplierInterface;
use CodedCell\Traits\PaginateTrait;
use Excel;
use Flash;
use Illuminate\Http\Request;
use Input;
use Mail;
use Redirect;
use Response;

class SupplierController extends Controller
{
    use PaginateTrait;

    public function __construct(SupplierInterface $supplier)
    {
        $this->supplier = $supplier;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('glance', Supplier::class);
        $suppliers = $this->supplier->all(array());
        $supplierAmountReport = $this->supplier->suppliersReportAmount();
        $message = "List of all suppliers and what you have spent on them";
        $data = json_encode($supplierAmountReport);
        $data = str_replace("'", "", $data);
        return View('suppliers/index')->with(compact('suppliers', 'message'))->with('supplierAmountReport', $data);
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $model = $this->supplier->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Supplier::class);
        return View('suppliers/create_supplier');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Supplier::class);
        $this->supplier->createSupplier($request->all());
        return Redirect::action('SupplierController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $supplier = $this->supplier->getSupplierById($id);
        $this->authorize('view', $supplier);
        return View('suppliers.view_supplier')->with(compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $page = $request->get('page', 1);
        //$path = $request->path(); $request->query
        $sort = $request->only('sortBy', 'direction');
        $search = $request->only('search');
        $suppliers = $this->supplier->all(compact('sort', 'page', 'search'));
        $supplier = $this->supplier->getSupplierById($id);
        $this->authorize('view', $supplier);
        return View('suppliers/create_supplier')->with(compact('suppliers'))->with(compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->supplier->updateSupplier($id, $request->all());
        return Redirect::action('SupplierController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->supplier->deleteSupplier($id);
        return Response::json(['ok' => 'ok']);
    }

    public function getDeleted()
    {
        $suppliers = $this->supplier->getDeletedSuppliers();
        $restore = 1;
        $message = "All Deleted Suppliers";
        return View('suppliers/index')->with(compact('suppliers', 'restore', 'message'));
    }

    public function restore($id)
    {
        $this->supplier->restoreSupplier($id);
        return Redirect::action('SupplierController@index');
    }


}
