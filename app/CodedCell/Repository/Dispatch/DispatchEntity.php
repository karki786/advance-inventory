<?php namespace CodedCell\Repository\Dispatch;

use App\Dispatch;
use App\ProductLocation;
use Carbon;
use CodedCell\Repository\Product\ProductInterface;
use CodedCell\Repository\Settings\SettingsInterface;
use CodedCell\Repository\Staff\StaffInterface;
use DB;
use Event;
use Auth;

/**
 * Class DispatchItem
 * @package CodedCell\Repository\Dispatch
 */
class DispatchEntity implements DispatchInterface
{


    /**
     * @param ProductInterface $product
     * @param StaffInterface $user
     */
    public function __construct(ProductInterface $product, StaffInterface $staff, SettingsInterface $setting)
    {
        $this->product = $product;
        $this->staff = $staff;
        $this->setting = $setting;
    }

    /**
     * @param array $params
     * @return mixed
     * Returns all paginated dispatches
     */
    public function all(array $params)
    {


        return Dispatch::with('product')
            ->with('staff')
            ->with('warehouse')
            ->with('binLocation')
            ->with('department')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $dispatch = Dispatch::with('product')
            ->with('staff')
            ->with('warehouse')
            ->with('binLocation')
            ->with('department');
        if ($filter != null) {
            $dispatch = $dispatch;
        }
        if ($scope != null) {
            $dispatch = $dispatch->$scope();
        }
        if ($paginate) {
            return $dispatch->paginate($perPage, $columns);
        } else {
            return $dispatch->get();
        }
    }

    /**
     * @param $item
     * @param $search
     * @return mixed used to search for a dispatch
     * used to search for a dispatch
     * @internal param $table
     */
    public function search($item, $search)
    {
        $columns = [
            'products.productName',
            'staff.name',
            'dispatches.amount',
            'dispatches.totalCost',
            'departments.name'
        ];
        $first = $columns[1];
        unset($columns[1]);
        $item = $item->where($first, 'LIKE', "%{$search}%");
        foreach ($columns as $column) {
            $item = $item->orWhere($column, 'LIKE', "%{$search}%");
        }
        return $item;
    }

    /**
     * @param $date
     * @return mixed
     * Gets all dispatch from a certain date
     */
    public function allFrom($date)
    {
        return Dispatch::with('product')
            ->with('staff')
            ->orderBy('created_at', 'DESC')
            ->where('created_at', '>', $date)
            ->get();
    }

    /**
     * @param $date
     * @return mixed
     * Gets all deleted dispatch from a certain date
     */
    public function allDeletedFrom($date)
    {
        return Dispatch::onlyTrashed()
            ->with('product')
            ->with('staff')
            ->orderBy('created_at', 'DESC')
            ->where('created_at', '>', $date)
            ->get();
    }

    /**
     * @return mixed
     * Gets all deleted dispatch
     */
    public function getDeletedDispatch()
    {
        return Dispatch::with('product')
            ->with('staff')->onlyTrashed()
            ->orderBy('deleted_at', 'DESC')
            ->get();
    }

    /**
     * @return mixed
     * Gets all defective dispatch
     */
    public function getDefective()
    {
        return Dispatch::with('product')
            ->with('staff')->onlyTrashed()
            ->orderBy('deleted_at', 'DESC')
            ->where('isReturned', '=', 1)
            ->get();
    }

    /**
     * @return mixed
     * Gets all non-deleted dispatch count
     */
    public function getDispatchCount()
    {
        return Dispatch::with('product')->with('staff')->count();
    }

    /**
     * @return mixed
     * Gets all deleted dispatches
     */
    public function getDeletedCount()
    {
        return Dispatch::onlyTrashed()->count();
    }

    /**
     * Dispatch Item to Employee reduces the amount in the inventory List
     * @param $product
     * @return static
     */
    public function dispatch($product)
    {
        return Dispatch::create($product);
    }

    /**
     * Deletes a Dispatch from the inventory and returns the item to the inventory
     * @param $id
     * @param $product
     * @return int
     */
    public function delete($id)
    {
        $dispatch = Dispatch::findOrFail($id);
        if (Auth::user()->can('delete', $dispatch)) {
            return Dispatch::destroy($id);
        }

    }

    /**
     * Updates an existing dispatch in the dispatch
     * It first returns the Item to the Inventory List
     * And then dispatches it a new
     * @param $id
     * @param $product
     * @return mixed|void
     */
    public function updateDispatch($id, $product)
    {
        $dispatch = Dispatch::findOrFail($id);
        if (Auth::user()->can('update', $dispatch)) {
            $dispatch->update($product);
        }

    }

    /**
     * Gets a dispatch by ID
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getById($id)
    {
        return Dispatch::with('product')
            ->with('staff')
            ->with('warehouse')
            ->with('binLocation')
            ->with('department')->withTrashed()
            ->where('id', '=', $id)
            ->firstOrFail();
    }

    /**
     * Restore a deleted Dispatch
     * @param $id
     * @return mixed
     */
    public function restoreDispatch($id)
    {
        return Dispatch::withTrashed()->where('id', $id)->restore();
    }

    /**
     * @return mixed
     * gets all dispatch for today
     */
    public function getDailyDispatchReport()
    {
        $x = array(DB::raw('sum(dispatches.amount)as dispatchcount'), DB::raw('DATE(dispatches.created_at) day'));
        return Dispatch::leftJoin('products', 'dispatches.dispatchedItem', '=', 'products.id')
            ->select($x)
            ->groupBy(DB::raw('DATE(dispatches.created_at)'))
            ->where('dispatches.created_at', '>', Carbon\Carbon::today()->subMonth())
            ->get();

    }

    public function getMonthlyDispatchReport()
    {
        $x = array(
            'products.productName',
            DB::raw('sum(dispatches.amount)as dispatchcount'),
            DB::raw('MONTH(dispatches.created_at) month')
        );
        return Dispatch::leftJoin('products', 'dispatches.dispatchedItem', '=', 'products.id')
            // ->select(DB::raw('DATE(dispatches.created_at),sum(dispatches.amount) as dispatchcount'))
            ->select($x)
            ->groupBy('products.productName', DB::raw('MONTH(dispatches.created_at)'))
            ->orderBy('month')
            ->get();
    }

    public function getCost()
    {
        return Dispatch::where('created_at', '>', Carbon::today()->subMonth())->sum('totalCost');
    }

    /**
     * Get Dispatch By Supplier
     * @param $productId
     * @return mixed
     */
    public function getDispatchByProduct($productId)
    {
        return Dispatch::with('product')
            ->with('staff')
            ->with('warehouse')
            ->with('binLocation')
            ->with('request')
            ->with('department')->withTrashed()
            ->where('dispatchedItem', '=', $productId)
            ->get();
    }

    public function findBy($field, $equal, $value)
    {
        return Dispatch::where($field, $equal, $value)
            ->with('product')
            ->with('staff')
            ->with('warehouse')
            ->with('binLocation')
            ->with('request')
            ->with('department')
            ->orderBy('created_at', 'DESC')->get();
    }

}
