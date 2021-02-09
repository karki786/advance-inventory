<?php namespace CodedCell\Repository\Restock;

use App\Helper;
use App\Product;
use App\ProductLocation;
use App\Restock;
use Carbon\Carbon;
use Clockwork\Storage\Storage;
use App\StorageLocation;
use CodedCell\Repository\Product\ProductInterface;
use CodedCell\Repository\Settings\SettingsInterface;
use DB;
use Auth;

/**
 * Class RestockItem
 * @package CodedCell\Repository\Restock
 */
class RestockEntity implements RestockInterface
{


    /**
     * @param ProductInterface $product
     */
    public function __construct(ProductInterface $product, SettingsInterface $setting)
    {
        $this->product = $product;
        $this->setting = $setting;

    }

    /**
     * @param array $params
     * @return mixed
     * Gets all restocked items
     */
    public function all(array $params)
    {
        return Restock::with('product')
            ->with('supplier')
            ->with('user')
            ->with('warehouse')
            ->with('binLocation')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $restock = Restock::with('product')
            ->with('supplier')
            ->with('user')
            ->with('warehouse')
            ->with('binLocation');
        if ($filter != null) {
            $restock = $restock->orWhere('productName', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            $restock = $restock->$scope();
        }
        if ($paginate) {
            return $restock->paginate($perPage, $columns);
        } else {
            return $restock->get();
        }
    }

    /**
     * @return mixed
     * Gets all defective items
     */
    public function getDefective()
    {
        return Restock::join('products', 'products.id', '=', 'restocks.productID')
            ->onlyTrashed()
            ->where('restocks.isDamagedReturned', '=', 1)
            ->join('suppliers', 'suppliers.id', '=', 'restocks.supplierID')
            ->select('restocks.*')
            ->with('product')
            ->with('supplier')
            ->with('user')
            ->get();
    }

    /**
     * @param $item
     * @param $search
     * @param $table
     * @return mixed
     * Used to search restocks
     */
    public function search($item, $search, $table)
    {
        $columns = ['products.productName', 'suppliers.supplierName'];

        $item = $item->where(function ($query) use ($search, $columns) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', "%{$search}%");
            }
        });
        return $item;
    }

    /**
     * @param $date
     * @return mixed
     * Used to get suppliers from a certain date
     */
    public function allFrom($date)
    {
        return Restock::with('product')
            ->with('supplier')
            ->where('created_at', '>', $date)
            ->get();
    }

    /**
     * @param $date
     * @return mixed
     * Used to get deleted supliers from a certain date
     */
    public function allDeletedFrom($date)
    {
        return Restock::onlyTrashed()
            ->with('product')
            ->with('supplier')
            ->where('created_at', '>', $date)
            ->get();
    }

    /**
     * @return mixed
     * used to get all deleted suppliers
     */
    public function getDeleted()
    {
        return Restock::onlyTrashed()
            ->with('product')
            ->with('supplier')
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * Records a new restock of a product in db
     * @param $product
     * @return static
     */
    public function restock($product)
    {
        $prod = Product::find($product['productID']);
        if ($prod->usesMultipleStorage) {
            $loc = StorageLocation::find($product['productLocationId']);
            $product['binLocationId'] = $loc->id;
            $product['warehouseId'] = $loc->whsId;
            $loc = ProductLocation::create(array(
                'productId' => $product['productID'],
                'productLocation' => $loc->id,
                'productLocationName' => $loc->warehouse->whsName,
                'binLocation' => $loc->id,
                'binLocationName' => $loc->binCode,
                'productBarcode' => $prod->barcode,
                'unitCost' => $prod->unitCost,
                'sellingPrice' => $prod->sellingPrice,
                'amount' => $product['amount']
            ));
            $product['locationHash'] = $loc->hash;
        }
        $product = array_except($product, ['_token']);
        Restock::create($product);

    }

    /**
     * Deletes a restock and decreases amount of an item in the inventory list
     * @param $id
     * @param $product
     */
    public function delete($id, $product)
    {
        $restock = Restock::findOrFail($id);
        if (Auth::user()->can('delete', $restock)) {
            Restock::destroy($id);
        }

    }

    /**
     * Helper Function to get restock by id
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getById($id)
    {
        return Restock::findOrFail($id);
    }

    /**
     * Updates a resock of an item it first decreases the amount then adds the correct amount
     * @param $id
     * @param $product
     */
    public function updateRestock($id, $product)
    {
        $restock = Restock::findOrFail($id);
        if (Auth::user()->can('update', $restock)) {
            $restock->update($product);
        }

    }

    public function getRestocksCount()
    {
        return Restock::all()->count();
    }

    /**
     * @return mixed
     * Get count of all deleted restocks
     */
    public function getDeletedRestocksCount()
    {
        return Restock::onlyTrashed()->count();
    }

    /**
     * Restore a deleted Restock
     * @param $id
     * @return mixed
     */
    public function restoreRestock($id)
    {
        return Restock::withTrashed()->where('id', $id)->restore();
    }

    /**
     * @param $days
     * @return mixed
     * Get cost for dashboard
     */
    public function getCost($days)
    {
        return Restock::where('created_at', '>', Carbon::today()->subMonth())->sum('itemCost');
    }

    /**
     * Get Daily Restock of Goods
     * @return mixed
     */
    public function getDailyRestockGraph()
    {
        $x = array(DB::raw('sum(restocks.amount)as restockcount'), DB::raw('DATE(restocks.created_at) day'));
        return Restock::select($x)
            ->groupBy(DB::raw('DATE(restocks.created_at)'))
            ->where('restocks.created_at', '>', Carbon::today()->subMonth())
            ->get();
    }

    public function findBy($field, $equal, $value)
    {
        return Restock::where($field, $equal, $value)
            ->with('product')
            ->with('supplier')
            ->with('user')
            ->orderBy('created_at', 'DESC')->get();
    }

}
