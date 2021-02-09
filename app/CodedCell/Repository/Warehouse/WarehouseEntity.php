<?php namespace CodedCell\Repository\Warehouse;

use App\ProductLocation;
use App\StorageLocation;
use App\Warehouse;
use DB;
use Auth;

class WarehouseEntity implements WarehouseInterface
{
    /**
     * Get Products in a particular Warehouse
     * @param $id
     */
    public function getProductsInWarehouse($id)
    {
        /**
         * $x = Product::whereHas('locations', function ($query) use ($id) {
         * $query->where('productLocation', '=', $id);
         * })->get();
         * **/

        return ProductLocation::with('product')->whereProductlocation($id)->get();

    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $warehouses = Warehouse::with('binLocations')->with('products');
        if ($filter != null) {
            $warehouses = $warehouses->where('whsName', 'LIKE', '%' . $filter . '%')
                ->orwhere('whsStreet', 'LIKE', '%' . $filter . '%')
                ->orwhere('whsZipCode', 'LIKE', '%' . $filter . '%')
                ->orwhere('whsCity', 'LIKE', '%' . $filter . '%')
                ->orwhere('whsCountry', 'LIKE', '%' . $filter . '%')
                ->orwhere('whsState', 'LIKE', '%' . $filter . '%')
                ->orwhere('whsBuilding', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            $warehouses = $warehouses->$scope();
        }

        if ($paginate) {
            return $warehouses->paginate($perPage, $columns);
        } else {
            return $warehouses->get();
        }
    }

    public function paginateDetails($id, $perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $warehouses = StorageLocation::with('products')->whereWhsid($id);
        if ($filter != null) {
            $warehouses = $warehouses->where('binCode', 'LIKE', '%' . $filter . '%')
                ->orwhere('binDescription', 'LIKE', '%' . $filter . '%')
                ->orwhere('binBarcode', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            $warehouses = $warehouses->$scope();
        }

        if ($paginate) {
            return $warehouses->paginate($perPage, $columns);
        } else {
            return $warehouses->get();
        }
    }


    /**
     * Get Bin Location
     * @return mixed
     */
    public function getWarehouseLocation($id)
    {
        return StorageLocation::find($id);
    }


    /**
     *Get Warehouse From Bin Location
     */
    public function getWarehouseFromLocation($id)
    {
        $warehouse = StorageLocation::find($id);
        return Warehouse::find($warehouse->whsId);
    }

    /**
     * Returns the number of warehouses
     * @return mixed
     */
    public function getWarehouseCount()
    {
        return Warehouse::all()->count();
    }


    /**
     * Get Warehouse Locations
     * @param $id
     * @return mixed
     */
    public function getWarehouseLocationsApi($id)
    {
        return StorageLocation::whereWhsid($id)->select(DB::raw("CONCAT(id, ':', binCode) as value"), 'binCode as text')->get();
    }


    /**
     * Get All user Warehouse
     * @return mixed
     */
    public function getWarehouse($id)
    {
        return Warehouse::find($id);
    }


    /**
     * Get List of Warehouse for input
     * @return mixed
     */
    public function getWarehouseList()
    {
        return Warehouse::select(DB::raw("CONCAT(id, ':', whsName) as value"), 'whsName as text')->get()->pluck('text', 'value');
    }

    /**
     * Get List of Warehouse for input
     * @return mixed
     */
    public function getWarehouseSelectList()
    {
        return Warehouse::all()->pluck('whsName', 'id');
    }


    /**
     * Get All user Warehouse
     * @return mixed
     */
    public function getWarehouses()
    {
        return Warehouse::with('binLocations')->with('products')->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Get Warehouse From Id
     * @param $warehouseId
     * @return mixed
     */
    public function getWarehouseForDisplay($warehouseId)
    {
        return Warehouse::with('binLocations')->find($warehouseId);
    }

    /**
     * Get Warehouse List of Location
     * @param $warehouseId
     * @return mixed
     */
    public function getWarehouseLocations($warehouseId)
    {
        return StorageLocation::with('products')->whereWhsid($warehouseId)->get();
    }

    /**
     * Save a Warehouse with an Address attached.
     * @param array $customer
     * @param array $address
     * @return mixed
     */
    public function saveWarehouseWithLocation(array $warehouse, array $location)
    {
        $warehouse = Warehouse::create($warehouse);
        $warehouse->addresses()->create($location);
        return $warehouse;
    }

    /**
     * Save a new Warehouse with no address
     * @param array $customer
     * @return mixed
     */
    public function saveWarehouse(array $warehouse)
    {
        return Warehouse::create($warehouse);
    }

    /**
     * Save an existing Warehouse Location
     * @param array $customer
     * @return mixed
     */
    public function saveWarehouseLocation(array $location)
    {
        return StorageLocation::create($location);
    }

    /**
     * Used to soft delete a customer from database
     * @param $warehouseId
     * @param bool $purge
     * @return mixed
     */
    public function removeWarehouse($warehouseId, $purge = false)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);
        if (Auth::user()->can('delete', $warehouse)) {
            return Warehouse::destroy($warehouseId);
        }

    }

    /**
     * Removes Warehouse address
     * @param $locationId
     * @param bool $purge
     * @return mixed
     */
    public function removeWarehouseLocation($locationId, $purge = false)
    {
        return StorageLocation::destroy($locationId);
    }

    /**
     * Update an existing Warehouse details
     * @param $warehouseId
     * @param array $customer
     * @return mixed
     */
    public function updateWarehouse($warehouseId, array $customer)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);
        if (Auth::user()->can('update', $warehouse)) {
            return $warehouse->update($customer);
        }

    }

    /**
     * Update an Existing Warehouse Address
     * @param $locationId
     * @param array $address
     * @return mixed
     */
    public function updateWarehouseLocation($locationId, array $location)
    {
        return StorageLocation::findOrFail($locationId)->update($location);
    }

    public function getWarehouseUtilization()
    {
        $x = array(DB::raw('sum(product_locations.amount)as quantity'), DB::raw('warehouses.whsName'));
        return Warehouse::leftJoin('product_locations', 'warehouses.id', '=', 'product_locations.productLocation')
            ->select($x)
            ->groupBy(DB::raw('warehouses.id'))
            ->having('quantity', '>', 0)
            ->get();
    }
}
