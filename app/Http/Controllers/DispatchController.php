<?php namespace App\Http\Controllers;

use App\Events\DispatchEdit;
use App\Events\DispatchRaised;
use App\Http\Requests;
use App\Http\Requests\DispatchFormRequest;
use Carbon;
use Clockwork;
use App\Dispatch;
use CodedCell\Repository\Dispatch\DispatchInterface;
use CodedCell\Repository\Product\ProductInterface;
use CodedCell\Repository\User\UserInterface;
use CodedCell\Traits\PaginateTrait;
use Excel;
use Flash;
use Input;
use Mail;
use Redirect;
use Response;
use Illuminate\Http\Request;

class DispatchController extends Controller
{
    use PaginateTrait;

    public function __construct(
        ProductInterface $product,
        UserInterface $user,
        DispatchInterface $dispatch
    )
    {
        $this->product = $product;
        $this->user = $user;
        $this->dispatch = $dispatch;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->authorize('glance', Dispatch::class);
        $sort = $request->only('sortBy', 'direction');
        $search = $request->only('search');
        $dispatchedItems = $this->dispatch->all(compact('sort', 'search'));
        $dispatchTrend = $this->dispatch->getDailyDispatchReport();
        $message = "Dispatched Items Recent First";
        return View('dispatches/view_dispatches')->with(compact('dispatchedItems', 'message'))->with('dispatchTrend',
            json_encode($dispatchTrend));
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $model = $this->dispatch->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Dispatch::class);
        return View('dispatches/create_dispatch');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, DispatchFormRequest $validate)
    {
        $this->authorize('create', Dispatch::class);
        $this->dispatch->Dispatch($request->all());
        return Redirect::action('DispatchController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $dispatch = $this->dispatch->getById($id);
        $this->authorize('view',$dispatch);
        return View('dispatches.view_dispatch')->with(compact('dispatch'));
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
        $dispatch = $this->dispatch->getById($id);
        $this->authorize('view',$dispatch);
        if ($dispatch->product->usesMultipleStorage) {
            $dispatch->productId = $dispatch->productLocationHash . '-' . 'M';

        } else {
            $dispatch->productId = $dispatch->productLocationHash . '-' . 'N';
        }
        $dispatch->hash = $dispatch->productLocationHash;
        $dispatch->prod_id = $dispatch->productId;
        return View('dispatches.create_dispatch')->with(compact('dispatch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id, Requests\DispatchFormEditRequest $validate)
    {
        $this->dispatch->updateDispatch($id, $request->all());
        return Redirect::action('DispatchController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        $this->dispatch->delete($id, $request->all());
        return Response::json(['ok' => 'ok']);
    }

    /**
     * @return $this
     */
    public function getDeleted()
    {
        $dispatchedItems = $this->dispatch->getDeletedDispatch();
        $restore = 1;
        $message = "Deleted Dispatches";
        return View('dispatches.view_dispatches')->with(compact('dispatchedItems', 'restore', 'message'));
    }

    /**
     * @return $this
     */
    public function getDefective()
    {
        $dispatchedItems = $this->dispatch->getDefective();
        $restore = 1;
        $message = "Deleted items that have been marked as defective";
        return View('dispatches.view_dispatches')->with(compact('dispatchedItems', 'restore', 'message'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $this->dispatch->restoreDispatch($id);
        return Redirect::action('DispatchController@index');
    }

    public function getDispatchItem($id, Request $request)
    {
        $params = explode('-', $id);
        $product = $this->product->getProductForAjaxGrid($params[0], $params[1]);
        return $product;
    }
}
