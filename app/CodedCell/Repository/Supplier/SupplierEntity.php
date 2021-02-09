<?php namespace CodedCell\Repository\Supplier;

use App\PurchaseOrder;
use App\Restock;
use App\Supplier;
use CodedCell\Repository\Settings\SettingsInterface;
use DB;
use Schema;
use Auth;

/**
 * Class NewSupplier
 * @package CodedCell\Repository\Supplier
 */
class SupplierEntity implements SupplierInterface
{
    public function __construct(SettingsInterface $setting)
    {
        $this->setting = $setting;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function all(array $params)
    {

        //Search
        $supplier = new Supplier();

        $supplier = $supplier->leftJoin('restocks', 'suppliers.id', '=', 'restocks.supplierID')
            ->selectRaw('suppliers.* , count(restocks.id) as restockscount, sum(restocks.unitCost) as restockssum')
            ->groupBy('suppliers.id');


        return $supplier->get();

    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $supplier = Supplier::with('orders');
        if ($filter != null) {
            $supplier = $supplier->where('supplierName', 'LIKE', '%' . $filter . '%')
                ->orwhere('address', 'LIKE', '%' . $filter . '%')
                ->orwhere('location', 'LIKE', '%' . $filter . '%')
                ->orwhere('website', 'LIKE', '%' . $filter . '%')
                ->orwhere('phone', 'LIKE', '%' . $filter . '%')
                ->orwhere('email', 'LIKE', '%' . $filter . '%')
                ->orwhere('remarks', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            $supplier = $supplier->$scope();
        }
        if ($paginate) {
            return $supplier->paginate($perPage, $columns);
        } else {
            return $supplier->get();
        }
    }

    /**
     * @param $item
     * @param $search
     * @param $table
     * @return mixed
     * Used for searching Suppliers
     */
    public function search($item, $search, $table)
    {
        $columns = Schema::getColumnListing($table);
        unset($columns[0]);
        $first = $columns[1];
        $item = $item->where(function ($query) use ($search, $columns) {
            foreach ($columns as $column) {
                $query->orWhere('suppliers.' . $column, 'LIKE', "%{$search}%");
            }
        });
        return $item;
    }

    public function allSuppliersReport()
    {
        return Supplier::leftJoin('restocks', 'suppliers.id', '=', 'restocks.supplierID')
            ->selectRaw('suppliers.supplierName ,suppliers.phone,suppliers.website,suppliers.email,suppliers.supplierDiscount, count(restocks.id) as restockscount, sum(restocks.unitCost) as restockssum,suppliers.created_at as SupplierSince')
            ->groupBy('suppliers.id')
            ->get(['restockscount']);
    }

    public function allDeletedSuppliersReport()
    {
        //return Supplier::paginate(env('RECORDS_VIEW'));
        return Supplier::leftJoin('restocks', 'suppliers.id', '=', 'restocks.supplierID')
            ->selectRaw('suppliers.* , count(restocks.id) as restockscount, sum(restocks.unitCost) as restockssum')
            ->groupBy('suppliers.id')
            ->onlyTrashed()
            ->get();
    }

    public function getDeletedSuppliers()
    {
        return Supplier::leftJoin('restocks', 'suppliers.id', '=', 'restocks.supplierID')
            ->selectRaw('suppliers.* , count(restocks.id) as restockscount, sum(restocks.unitCost) as restockssum')
            ->groupBy('suppliers.id')
            ->onlyTrashed()
            ->get();
    }

    /**
     * Returns Supplier list for use in select list
     * @return mixed
     */
    public function supplierList()
    {
        return Supplier::pluck('supplierName', 'id');
    }

    /**
     * @return mixed
     */
    public function getSuppliersCount()
    {
        return Supplier::all()->count();
    }

    /**
     * @return mixed
     */
    public function getDeletedSuppliersCount()
    {
        return Supplier::onlyTrashed()->count();
    }

    /**
     * @param $id
     * @return int
     */
    public function deleteSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        if (Auth::user()->can('delete', $supplier)) {
            return Supplier::destroy($id);
        }

    }

    /**
     * @param $id
     * @return mixed
     */
    public function restoreSupplier($id)
    {
        return Supplier::withTrashed()->where('id', $id)->restore();
    }

    /**
     * @param $supplier
     * @return static
     */
    public function createSupplier($supplier)
    {
        return Supplier::create($supplier);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSupplierById($id)
    {
        return Supplier::with('orders')->with('restocks')->findOrFail($id);
    }

    /**
     * @param $id
     * @param $newSupplier
     */
    public function updateSupplier($id, $newSupplier)
    {
        $supplier = Supplier::withTrashed()->findOrFail($id);
       if (Auth::user()->can('update', $supplier)) {
           $supplier->update($newSupplier);
       }

    }

    /**
     * @return mixed
     */
    public function suppliersReportAmount()
    {
        return Supplier::join('restocks', 'suppliers.id', '=', 'restocks.supplierID', 'inner')
            ->selectRaw('suppliers. supplierName as label, CAST(sum(restocks.unitCost) as UNSIGNED) as value')
            ->groupBy('suppliers.id')
            ->orderBy('value')
            ->get();
    }

    /**
     * Get Dispatch Restock as Specified by User
     * @param $productId
     * @param string $perPeriod
     * @return mixed
     */
    public function getSupplierDeliveryGraph($supplierId, $perPeriod = "MONTH")
    {
        $x = array(
            'products.productName',
            DB::raw('sum(restocks.amount)as restockcount'),
            DB::raw("{$perPeriod}(restocks.created_at) month")
        );
        return Restock::withoutGlobalScopes()->leftJoin('products', 'restocks.productID', '=', 'products.id')
            ->select($x)
            ->where('restocks.supplierID', '=', $supplierId)
            ->groupBy('products.productName', DB::raw("{$perPeriod}(restocks.created_at)"))
            ->orderBy('month')
            ->get();
    }

    /**
     * Get Supplier Deliveries Graph
     * @param $supplierId
     * @return mixed
     */
    public function getSupplierDeliveryTimeGraph($supplierId)
    {
        $x = array(
            'lpoNumber',
            DB::raw('DATEDIFF(updated_at,lpoDate)as days'),
        );
        return PurchaseOrder::withoutGlobalScopes()
            ->select($x)
            ->where('fullDelivery', '=', 1)
            ->where('supplierId', '=', $supplierId)
            ->get();
    }

    /**
     * Get Supplier Lpos.
     * @param $supplierId
     * @return mixed
     */
    public function getSupplierLpos($supplierId)
    {

        return purchaseOrder::with('orders')
            ->with('supplier')
            ->where('supplierId', '=', $supplierId)
            ->where('fullDelivery', '=', 1)
            ->orderBy('lpoDate')
            ->get();
    }


}
