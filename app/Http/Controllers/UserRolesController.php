<?php namespace App\Http\Controllers;

use App\Http\Requests;
use CodedCell\Repository\UserRoles\UserRolesInterface;
use CodedCell\Repository\User\UserInterface;
use Illuminate\Http\Request;

class UserRolesController extends Controller
{

    public function __construct(UserRolesInterface $userrole, UserInterface $user)
    {
        $this->userroles = $userrole;
        $this->user = $user;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $userroles = $this->userroles->all();
        $message = "List Of All Suppliers";
        return view('users/userroles')->with(compact('userroles', 'message'));
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
    public function store(Request $request)
    {
        $this->userroles->create($request->except('_token'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {

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
