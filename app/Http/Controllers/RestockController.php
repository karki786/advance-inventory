<?php namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests;
use App\Http\Requests\RestockFormRequest;
use App\Restock;
use Auth;
use Carbon;
use CodedCell\Repository\Product\ProductInterface;
use CodedCell\Repository\Restock\RestockInterface;
use CodedCell\Repository\Supplier\SupplierInterface;
use CodedCell\Traits\PaginateTrait;
use Excel;
use Flash;
use Image;
use Input;
use Mail;
use Redirect;
use Response;
use Illuminate\Http\Request;

class RestockController extends Controller
{

    use PaginateTrait;

    public function __construct(
        RestockInterface $restock,
        ProductInterface $product,
        SupplierInterface $supllier
    )
    {
        $this->product = $product;
        $this->restock = $restock;
        $this->supplier = $supllier;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('glance', Restock::class);
        $allRestocks = $this->restock->all(array());
        $message = "Items that have been restocked recent first";
        return View('restocks/view_restocks')->with(compact('allRestocks', 'message'));
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $model = $this->restock->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Restock::class);
        return View('restocks/create_restock');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, RestockFormRequest $validate)
    {
        $this->authorize('create', Restock::class);
        $this->restock->restock($request->except('warehouseId'));
        return Redirect::action('RestockController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $restock = $this->restock->getById($id);
        $this->authorize('view', $restock);
        return View('restocks/view_restock')->with(compact('restock'));
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
        $restock = $this->restock->getById($id);
        $this->authorize('view', $restock);
        return View('restocks/create_restock')->with(compact('restock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->restock->updateRestock($id, $request->all());
        return Redirect::action('RestockController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $this->restock->delete($id, $request->all());
        return Response::json(['ok' => 'ok']);
    }

    public function getDeleted()
    {
        $allRestocks = $this->restock->getDeleted();
        $restore = 1;
        $message = "Items that are below Stock Warning Levels";
        return View('restocks/index')->with(compact('allRestocks', 'restore', 'message'));
    }

    public function getDefective()
    {
        $allRestocks = $this->restock->getDefective();
        $restore = 1;
        $message = "Items that have been deleted and marked as defective";
        return View('restocks/index')->with(compact('allRestocks', 'restore', 'message'));
    }

    public function restore($id)
    {
        $this->restock->restoreRestock($id);
        return Redirect::action('RestockController@index');
    }


    public function uploadDocs()
    {
        if (Input::hasFile('file')) {
            $product_image = Input::file('file');
            $destinationPath = Helper::downloadPath() . '/receipts/';
            $filename = str_random(6) . '_' . $product_image->getClientOriginalName();
            $save_path = $destinationPath;
            $product_image->move($save_path, $filename);
            return array('save_path' => $filename);
        }
    }

    public function getDownload()
    {
        $file = Input::query('file');
        $file = Helper::downloadPath() . '/receipts/' . $file;
        return Response::download($file);
    }
}
