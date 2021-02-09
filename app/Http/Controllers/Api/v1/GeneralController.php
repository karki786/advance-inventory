<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Product;
use App\ProductLocation;
use App\StorageLocation;
use App\Warehouse;
use CodedCell\Repository\Warehouse\WarehouseInterface;
use Illuminate\Http\Request;
use DB;

class GeneralController extends Controller
{
    public function __construct(WarehouseInterface $warehouse)
    {

        $this->warehouse = $warehouse;
    }

    public function getLocations($id)
    {
        return $this->warehouse->getWarehouseLocationsApi($id);
    }

    public function getWarehouses($id)
    {
        $ids = ProductLocation::whereProductid($id)->select('productLocation')->get();
        return Warehouse::select('whsName as text', 'id as id')->find($ids->toArray());
    }

    public function getBinLocations($id, $warehouse)
    {
        return ProductLocation::whereProductid($id)->whereProductlocation($warehouse)->select(DB::raw('concat(binLocationName,"(",sum(amount),")") as text'), 'id as id')->groupBy('binLocation')->where('amount', '>', 0)->get();
    }

    public function getBinLocationsForEdit($id, $warehouse)
    {
        return ProductLocation::whereProductid($id)->whereProductlocation($warehouse)->select(DB::raw('concat(binLocationName,"(",sum(amount),")") as text'), 'id as id')->groupBy('binLocation')->get();
    }

    public function getWarehouseBinLocations($warehouseId)
    {
        return StorageLocation::select('binCode as text', 'id as id')->whereWhsid($warehouseId)->get();
    }

    public function getProductIsMultiLocation($id)
    {
        $prod = Product::find($id);
        if ($prod) {
            return $prod->usesMultipleStorage;
        }
        return null;
    }

    public function deleteProductLocation($id)
    {
        return ProductLocation::destroy($id);
    }
}
