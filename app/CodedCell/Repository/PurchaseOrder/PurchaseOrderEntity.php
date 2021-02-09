<?php namespace CodedCell\Repository\PurchaseOrder;

use App\Company;
use App\Helper;
use App\Product;
use App\PurchaseOrder;
use App\PurchaseOrderItem;
use App\PurchaseRequest;
use App\PurchaseRequestItem;
use App\StorageLocation;
use App\Supplier;
use Auth;
use Carbon;
use App\ProductLocation;
use App\Restock;
use CodedCell\Repository\Product\ProductInterface;
use CodedCell\Repository\Restock\RestockInterface;
use CodedCell\Repository\Settings\SettingsInterface;
use DB;
use Excel;
use Facades\CodedCell\Classes\InventoryWatcher;
use File;
use Mail;
use Schema;

/**
 * Class PurchaseOrderEntity
 * @package CodedCell\Repository\PurchaseOrder
 */
class PurchaseOrderEntity implements PurchaseOrderInterface
{

    public function all($columns = array('*'))
    {
        return PurchaseOrder::with('orders')->orderBy('id', 'desc')->get($columns);
    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $purchaseOrder = PurchaseOrder::with('orders');
        if ($filter != null) {
            $purchaseOrder = $purchaseOrder->where('supplierName', 'LIKE', '%' . $filter . '%')
                ->orwhere('dateOfDelivery', 'LIKE', '%' . $filter . '%')
                ->orwhere('termsOfPayment', 'LIKE', '%' . $filter . '%')
                ->orwhere('deliverBy', 'LIKE', '%' . $filter . '%')
                ->orwhere('lpoNumber', 'LIKE', '%' . $filter . '%')
                ->orwhere('company', 'LIKE', '%' . $filter . '%')
                ->orwhere('lpoApprovedOn', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            $purchaseOrder = $purchaseOrder->$scope();
        }
        if ($paginate) {
            return $purchaseOrder->paginate($perPage, $columns);
        } else {
            return $purchaseOrder->get();
        }
    }

    private function buildLpoNumber($lpoString, $model)
    {
        $vars = array(
            '{$lpoNumber}' => $model->id,
            '{$date}' => Carbon::now()->day,
            '{$month}' => Carbon::now()->month,
            '{$year}' => Carbon::now()->year,
            '{$supplier}' => $model->supplierId,
        );

        return strtr($lpoString, $vars);
    }

    public function create(array $data, $relation)
    {
         $relation = collect($relation);
        $relation = $relation->map(function ($item) {
            // $item->quantity = $item->amount;
            $item->amount = $item->quantity;
            $item->unitCost = $item->sellingPrice;
            $item->productId = $item->prod_id;
            unset($item->quantity);
            unset($item->sellingPrice);
            unset($item->binLocation);
            unset($item->convertedPrice);
            unset($item->prod_id);
            unset($item->locationHash);
            unset($item->price);
            return $item;
        });
        $purchaseOrder = PurchaseOrder::create($data);
        $orderItems = $this->buildRelationship($relation);
        $purchaseOrder->orders()->saveMany($orderItems);
        $lpoString = Company::find(Auth::user()->companyId)->lpoNumberingFormat;
        $lpoString = $this->buildLpoNumber($lpoString, $purchaseOrder);
        $purchaseOrder->update(['lpoNumber' => $lpoString]);
        return $purchaseOrder;
    }

    private function buildRelationShip($arrayItems)
    {
        $empty = [];
        foreach ($arrayItems as $array) {
            array_push($empty, new PurchaseOrderItem((array)$array));
        }
        return $empty;
    }

    public function createRelation(array $data, $relation)
    {
        $data = $this->buildRelationShip($data);
        return $relation->orders()->saveMany($data);
    }

    public function update(array $data, $id)
    {
        $order = PurchaseOrder::findOrFail($id);
        if (Auth::user()->can('update', $order)) {
            return $order->update($data);
        }

    }

    public function delete($id)
    {
        $order = PurchaseOrder::findOrFail($id);
        if (Auth::user()->can('delete', $order)) {
            return PurchaseOrder::destroy($id);
        }

    }

    public function find($id, $columns = array('*'))
    {
        return PurchaseOrder::with('orders')->findOrFail($id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return PurchaseOrder::where($field, '=', $value)->firstOrFail($columns);
    }

    /**
     * Restock from purchase Order
     * @param $product
     * @param $supplierId
     */
    public function restockFromPurchaseOrder($product, $supplierId)
    {

        $storage = Product::find($product->productId)->usesMultipleStorage;
        if ($storage) {
            $location = StorageLocation::find($product->location);
            $loc = ProductLocation::create(array(
                'productId' => $product->productId,
                'unitCost' => $product->unitCost,
                'sellingPrice' => $product->sellingPrice,
                'binLocationName' => $location->binCode,
                'productLocationName' => $location->warehouse->whsName,
                'productLocation' => $location->whsId,
                'binLocation' => $location->id,
                'amount' => $product->received
            ));
            $item = PurchaseOrderItem::find($product->id);
            $item->increment('delivered', $product->received);
            $supplierId = PurchaseOrder::find($product->lpoId)->supplierId;
            Restock::create(array(
                'productID' => $product->productId,
                'unitCost' => $product->unitCost,
                'itemCost' => $product->received * $product->unitCost,
                'amount' => $product->received,
                'supplierID' => $supplierId,
                'lpoId' => $product->lpoId,
                'warehouseId' => $location->whsId,
                'binLocationId' => $location->id,
                'locationHash' => $loc->hash
            ));
        } else {
            $supplierId = PurchaseOrder::find($product->lpoId)->supplierId;
            $item = PurchaseOrderItem::find($product->id);
            $item->increment('delivered', $product->received);
            Restock::create(array(
                'productID' => $product->productId,
                'unitCost' => $product->unitCost,
                'itemCost' => $product->received * $product->unitCost,
                'amount' => $product->amount,
                'supplierID' => $supplierId,
                'lpoId' => $product->lpoId,

            ));
        }


    }


}
