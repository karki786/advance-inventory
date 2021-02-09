<?php namespace App\Http\ViewComposers;


use CodedCell\Repository\Department\DepartmentInterface;
use CodedCell\Repository\Staff\StaffInterface;
use Illuminate\Contracts\View\View;
use CodedCell\Repository\Product\ProductInterface;
use DB;
use Auth;
class DispatchesComposer
{

    public function __construct(ProductInterface $product, StaffInterface $staff, DepartmentInterface $department)
    {
        $this->product = $product;
        $this->staff = $staff;
        $this->department = $department;
    }

    public function compose(View $view)
    {
        $x = $this->product->getProductForDataGrid()->toArray();
        array_unshift($x, array('id' => 'null', 'multilocation' => 1, 'productName' => '', 'text' => 'Please Choose an Item'));
        $view->with('prods', $x);
        $view->with('products', $this->product->all()->pluck('productName','id'));
        $users = DB::table('staff')
            ->join('departments', 'departments.id', '=', 'staff.departmentId')
            ->where('staff.companyId', '=', Auth::user()->companyId)
            ->select('staff.id as id', DB::raw('concat(staff.name,"(",departments.name,")") as text'))->get();
        $view->with('users', $users);
        $view->with('departments', $this->department->departmentList());
    }


}
