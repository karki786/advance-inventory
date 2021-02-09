<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 1/7/2017
 * Time: 19:13
 */

namespace CodedCell\Repository\Receipt;

use App\Receipt;
use App\ReceiptItem;
use App\Company;
use Auth;
use Carbon\Carbon;
use CodedCell\Repository\Product\ProductInterface;

class ReceiptEntity implements ReceiptInterface
{
    protected $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function all($columns = array('*'))
    {
        return Receipt::with('items')->get($columns);
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        return Receipt::with('items')->paginate($perPage, $columns);
    }

    public function buildReceiptNumber($receiptFormat, $model)
    {
        $vars = array(
            '{$receiptNumber}' => $model->id,
            '{$date}' => Carbon::now()->day,
            '{$month}' => Carbon::now()->month,
            '{$year}' => Carbon::now()->year,
        );

        return strtr($receiptFormat, $vars);
    }

    public function create(array $data, $items)
    {
        $receipt = Receipt::create($data);
        $this->createRelation($items, $receipt);
        $receiptFormat = Company::find(Auth::user()->companyId)->receiptNumberingFormat;
        $receiptString = $this->buildReceiptNumber($receiptFormat, $receipt);
        $receipt->update(['receiptNo' => $receiptString]);
        $this->decreaseInWarehouse($receipt);
        return $receipt;
    }

    public function decreaseInWarehouse($receipt)
    {
        $items = $receipt->items;
        if ($items) {
            foreach ($items as $item) {
                if ($item->binLocation > 0 and $item != null) {
                    //$location = StorageLocation::find($item->binLocation);
                    $this->product->decreaseProductInWarehouse($item->quantity, $item->productId, $item->binLocation);
                } else {
                    $this->product->decreaseProduct($item->quantity, $item->productId);
                }
            }
        }
    }

    private function buildRelationShip($arrayItems)
    {
        $empty = [];
        foreach ($arrayItems as $array) {
            array_push($empty, new ReceiptItem((array)$array));
        }
        return $empty;
    }

    public function createRelation(array $data, $relation)
    {
        $data = $this->buildRelationShip($data);
        return $relation->items()->saveMany($data);
    }

    public function update(array $data, $items, $id)
    {
        $receipt = Receipt::find($id);
        $receipt->update($data);
        foreach ((array)$items as $item) {
            if (isset($item->id)) {
                //dd(collect($item)->except('creator', 'updater', 'created_at', 'updated_at')->toArray());
                $item = collect($item)->except('creator', 'updater', 'created_at', 'updated_at')->toArray();
                ReceiptItem::find($item['id'])->update((array)$item);
            } else {
                $receipt->items()->create((array)$item);
            }
        }

    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        $receipt = Receipt::find($id);
        $this->increaseInWarehouse($receipt);
        return Receipt::destroy($id);
    }

    private function increaseInWarehouse($receipt)
    {
        $items = $receipt->items;
        foreach ($items as $item) {
            if ($item->binLocation > 0 and $item != null) {
                $location = ProductLocation::find($item->binLocation);
                $this->product->increaseProductInWarehouse($item->quantity, $item->productId, $location->id, $location->productLocation, $location->binLocation);
            } else {
                $this->product->increaseProduct($item->quantity, $item->productId);
            }
        }
    }

    public function find($id, $columns = array('*'))
    {
        return Receipt::with('items')->find($id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return Receipt::where($field, '=', $value)->first($columns);
    }

}