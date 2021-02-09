<?php namespace CodedCell\Repository\Product;

use App\Product;
use App\ProductLocation;
use DB;
use DNS1D;
use DNS2D;
use Schema;
use Hashids\Hashids;

/**
 * Class StockItem
 * @package CodedCell\Repository\Product
 * Repository for Product Item
 */
class ProductEntity implements ProductInterface
{
    public function all($columns = array('*'))
    {
        return Product::with('photos', 'restocks', 'dispatches', 'locations')->get($columns);
    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $product = Product::with([
                'photos',
                'restocks',
                'dispatches',
                'locations'
            ]
        );
        if ($filter != null) {
            $product = $product->where('productName', 'LIKE', '%' . $filter . '%')
                ->orwhere('categoryName', 'LIKE', '%' . $filter . '%')
                ->orwhere('productSerial', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            if (is_array($scope)) {
                $parameter = $scope[1];
                $scope = $scope[0];
                $product = $product->$scope($parameter);
            } else {
                $product = $product->$scope();
            }
        }

        if ($paginate) {
            return $product->paginate($perPage, $columns);
        } else {
            return $product->get();
        }
    }

    public function create(array $data, $locations)
    {
        $locations = json_decode($locations);
        if ($data['usesMultipleStorage'] == 1) {
            $totalAmount = collect($locations)->sum('amount');
            $data['amount'] = $totalAmount;
        }
        $product = Product::create($data);
        if ($data['usesMultipleStorage'] == 1) {
            $locations = $this->buildRelationShip($locations);
            $product->locations()->saveMany($locations);
        }

        return $product;
    }

    private function buildRelationShip($arrayItems)
    {
        $empty = [];
        foreach ($arrayItems as $array) {
            array_push($empty, new ProductLocation((array)$array));
        }
        return $empty;
    }

    public function createRelation(array $data, $relation)
    {
        $data = $this->buildRelationShip($data);
        return $relation->locations()->saveMany($data);
    }

    public function update(array $data, $locations, $id)
    {
        return Product::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return Product::destroy($id);
    }

    public function find($id, $columns = array('*'))
    {
        return Product::with('photos', 'restocks', 'dispatches', 'locations')->findOrFail($id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return Product::where($field, '=', $value)->firstOrFail($columns);
    }

    /**
     * Get Warehouse Locations for Grid
     * @return array|static[]
     */
    public function getWarehouseLocationsForGrid()
    {
        return DB::table('warehouses')
            ->leftJoin('storage_locations', 'storage_locations.whsId', '=', 'warehouses.id')
            ->select(
                'storage_locations.id',
                'warehouses.whsName',
                'storage_locations.binCode',
                'storage_locations.whsId',
                DB::raw('CONCAT(warehouses.whsName,"-",storage_locations.binCode) as text')
            )
            ->orderBy('warehouses.whsName')
            ->get();
    }

    /**
     * Get product with its location
     * @return mixed
     */
    public function getProductForDataGrid()
    {
        /*
         dd(DB::table('products')
             ->leftJoin('product_locations', 'products.id', '=', 'product_locations.productId')
             ->select(DB::raw('product_locations.hash, products.sellingPrice as sp,products.location as lc, product_locations.sellingPrice,IF(product_locations.hash is not null,concat(product_locations.hash,"-","M"),concat(products.id,"-","N")) as id'), DB::raw('IF(product_locations.hash is not null,1,0) as multilocation'), 'products.productName', 'products.productName as text', 'product_locations.productLocationName', 'product_locations.binLocationName', 'product_locations.unitCost', DB::raw('sum(product_locations.amount) as locsum'), 'products.amount as amount')
             ->orderBy('products.productName')
             ->whereNull('products.deleted_at')
             ->groupBy('product_locations.hash', 'products.hash')
             ->get());
        */

        return DB::table('products')
            ->leftJoin('product_locations', 'products.id', '=', 'product_locations.productId')
            ->select(
                'product_locations.hash',
                'products.productName',
                'products.productName as text',
                'product_locations.productLocationName',
                'product_locations.binLocationName',
                'products.amount as amount',
                'product_locations.unitCost',
                'products.hash',
                DB::raw('IFNULL(products.sellingPrice,0) as sp'),
                'products.location as lc',
                DB::raw('IFNULL(product_locations.sellingPrice,0) as sellingPrice'),
                DB::raw('sum(product_locations.amount) as locsum'),
                DB::raw('IF(product_locations.hash is not null,concat(product_locations.hash,"-","M"),concat(products.id,"-","N")) as id'),
                DB::raw('IF(product_locations.hash is not null,1,0) as multilocation')
            )
            ->whereNull('products.deleted_at')
            ->groupBy('product_locations.hash', 'products.hash')
            ->get();
        /*
        dd($x);
        return DB::table('products')
            ->leftJoin('product_locations', 'products.id', '=', 'product_locations.productId')
            ->select(DB::raw('product_locations.hash, products.sellingPrice as sp,products.location as lc, product_locations.sellingPrice,IF(product_locations.hash is not null,concat(product_locations.hash,"-","M"),concat(products.id,"-","N")) as id'), DB::raw('IF(product_locations.hash is not null,1,0) as multilocation'), 'products.productName', 'products.productName as text', 'product_locations.productLocationName', 'product_locations.binLocationName', 'product_locations.unitCost', DB::raw('sum(product_locations.amount) as locsum'), 'products.amount as amount')
            ->orderBy('products.productName')
            ->whereNull('products.deleted_at')
            ->groupBy('product_locations.hash', 'products.hash')
            ->get();
        */
    }

    public function getProductForRestock()
    {
        return DB::table('products')
            ->leftJoin('product_locations', 'products.id', '=', 'product_locations.productId')
            ->select(DB::raw('product_locations.hash, products.sellingPrice as sp,products.location as lc, product_locations.sellingPrice,products.id'), DB::raw('IF(product_locations.hash is not null,1,0) as multilocation'), 'products.productName', 'products.productName as text', 'product_locations.productLocationName', 'product_locations.binLocationName', 'product_locations.unitCost', DB::raw('sum(product_locations.amount) as locsum'), 'products.amount as amount')
            ->orderBy('products.productName')
            ->groupBy('products.id')
            ->get();
    }

    public function getProductForAjaxGrid($id, $type)
    {
        if ($type == 'M') {
            return (array)DB::table('products')
                ->leftJoin('product_locations', 'products.id', '=', 'product_locations.productId')
                ->select(DB::raw('products.id as prod_id,products.productTaxRate as taxRate,product_locations.hash, products.sellingPrice as sp,products.location as lc, product_locations.sellingPrice,IF(product_locations.hash is not null,concat(product_locations.hash,"-","M"),concat(products.hash,"-","N")) as id'), DB::raw('IF(product_locations.hash is not null,1,0) as multilocation'), 'products.productName', 'products.productName as text', 'product_locations.productLocationName', 'product_locations.binLocationName', 'product_locations.productLocation', 'product_locations.unitCost', 'product_locations.amount', 'product_locations.binLocation')
                ->orderBy('products.productName')
                ->groupBy('product_locations.hash')
                ->where('product_locations.hash', $id)
                ->first();
        } else {
            return Product::select('products.id as prod_id', 'products.sellingPrice', 'products.productTaxRate as taxRate', 'products.id', 'products.productName', 'products.*')->find($id);
        }
    }

}
