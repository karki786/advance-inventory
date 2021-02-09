<?php

namespace App\Http\Controllers;

use App\ModulePermission;
use CodedCell\Repository\User\UserInterface;
use CodedCell\Repository\UserRoles\UserRolesInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $models;
    protected $actions;

    public function __construct(UserRolesInterface $userrole, UserInterface $user)
    {
        $this->userroles = $userrole;
        $this->user = $user;
        $this->middleware('auth');
        $this->models = array(
            array('text' => 'Receipt', 'id' => 'Receipt'),
            array('text' => 'Warehouse', 'id' => 'Warehouse'),
            array('text' => 'ProductCategory', 'id' => 'ProductCategory'),
            array('text' => 'UserRoles', 'id' => 'UserRoles'),
            array('text' => 'User', 'id' => 'User'),
            array('text' => 'Supplier', 'id' => 'Supplier'),
            array('text' => 'Staff', 'id' => 'Staff'),
            array('text' => 'Setting', 'id' => 'Setting'),
            array('text' => 'Restock', 'id' => 'Restock'),
            array('text' => 'PurchaseOrder', 'id' => 'PurchaseOrder'),
            array('text' => 'Product', 'id' => 'Product'),
            array('text' => 'Message', 'id' => 'Message'),
            array('text' => 'Invoice', 'id' => 'Invoice'),
            array('text' => 'Dispatch', 'id' => 'Dispatch'),
            array('text' => 'Department', 'id' => 'Department'),
            array('text' => 'Customer', 'id' => 'Customer'),
            array('text' => 'Company', 'id' => 'Company'),
            array('text' => 'SalesOrder', 'id' => 'SalesOrder'),
            array('text' => 'Currency', 'id' => 'Currency'),
            array('text' => 'InvoicePayment', 'id' => 'InvoicePayment'),
            array('text' => 'PurchaseOrder', 'id' => 'PurchaseOrder'),
            array('text' => 'Company', 'id' => 'Company'),
        );

        $this->actions = array(
            array('id' => 'canView', 'text' => 'canView'),
            array('id' => 'canCreate', 'text' => 'canCreate'),
            array('id' => 'canUpdate', 'text' => 'canUpdate'),
            array('id' => 'canDelete', 'text' => 'canDelete'),
            array('id' => 'canGlance', 'text' => 'canGlance'),
            array('id' => 'all', 'text' => 'All Actions'),
        );
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
        $actions = $this->actions;
        $models = $this->models;
        sort($this->actions);
        sort($this->models);
        $role = $this->userroles->find($request->id);
        $permissions = $role->permissions;
        $roleName = $role->name;
        $roleId = $role->id;
        return view('roles.create_role')->with(compact('models', 'actions', 'roleName', 'roleId', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->action == 'all') {
            foreach ($this->actions as $action) {
                if ($action['id'] != "all") {
                    ModulePermission::updateOrCreate(
                        [
                            'roleId' => $request->roleId,
                            'model' => $request->model
                        ],
                        [
                            $action['text'] => $request->permission
                        ]
                    );
                }
            }
            return redirect()->back();
        }
        ModulePermission::updateOrCreate(
            [
                'roleId' => $request->roleId,
                'model' => $request->model
            ],
            [
                $request->action => $request->permission
            ]
        );
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function assignAll(Request $request)
    {
        $role = $request->roleId;
        foreach ($this->models as $model) {
            ModulePermission::updateOrCreate(
                [
                    'roleId' => $role,
                    'model' => $model['text']
                ],
                [
                    'canCreate' => 1,
                    'canGlance' => 1,
                    'canView' => 1,
                    'canUpdate' => 1,
                    'canDelete' => 1,
                ]
            );
        }
        return redirect()->back();
    }
}
