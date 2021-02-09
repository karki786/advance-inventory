<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Staff;
use Auth;
use CodedCell\Repository\Staff\StaffInterface;
use CodedCell\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Response;

class StaffController extends Controller
{
    use PaginateTrait;

    public function __construct(StaffInterface $staff)
    {
        $this->staff = $staff;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->authorize('glance', Staff::class);
        $sort = $request->only('sortBy', 'direction');
        $search = $request->only('search');
        $users = $this->staff->all(compact('search', 'sort'));
        $message = "List Of Staff";
        return view('staff.view_staff')->with(compact('users', 'message'));
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $model = $this->staff->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Staff::class);
        return view('staff.createupdateuser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, Requests\StaffFormRequest $data)
    {
        $this->authorize('create', Staff::class);
        $data = $request->all();
        $data['companyId'] = Auth::user()->companyId;
        $this->staff->createStaff($data);
        return Redirect::action('StaffController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $staff = $this->staff->getStaffById($id);
        return view('staff.view_staffDetails')->with(compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->staff->getStaffById($id);
        $this->authorize('view', $user);
        return view('staff.createupdateuser')->with(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $this->staff->updateStaff($id, $data);
        return Redirect::action('StaffController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->staff->deleteStaff($id);
        return Response::json(['ok' => 'ok']);
    }

    public function getStaff()
    {
        return $this->staff->getStaffJson();
    }

    public function createStaff()
    {
        $staff = $this->staff->createStaff($request->all());
        return array('id' => $staff->id, 'text' => $staff->name);
    }

    public function getDeletedStaff()
    {
        $deleted = 1;
        $users = $this->staff->all(compact('deleted'));
        $message = "List Of Staff";
        $restore = 1;
        return view('staff.index')->with(compact('users', 'message', 'restore'));
    }

    public function restoreDeletedStaff($id)
    {
        $users = $this->staff->restoreStaff($id);
        return Redirect::action('StaffController@index');
    }

}
