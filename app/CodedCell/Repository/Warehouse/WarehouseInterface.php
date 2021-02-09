<?php


namespace CodedCell\Repository\Warehouse;


interface WarehouseInterface
{

    /**
     * Get Products in a particular Warehouse
     * @param $id
     */
    public function getProductsInWarehouse($id);

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'));

    public function paginateDetails($id,$perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'));

    /**
     * Get Bin Location
     * @return mixed
     */
    public function getWarehouseLocation($id);

    /**
     *Get Warehouse From Bin Location
     */
    public function getWarehouseFromLocation($id);

    /**
     * Returns the number of warehouses
     * @return mixed
     */
    public function getWarehouseCount();

    /**
     * Get Warehouse Locations
     * @param $id
     * @return mixed
     */
    public function getWarehouseLocationsApi($id);

    /**
     * Get List of Warehouse for input
     * @return mixed
     */
    public function getWarehouseList();

    /**
     * Get List of Warehouse for input
     * @return mixed
     */
    public function getWarehouseSelectList();

    /**
     * Get All user Warehouse
     * @return mixed
     */
    public function getWarehouses();

    /**
     * Get All user Warehouse
     * @return mixed
     */
    public function getWarehouse($id);

    /**
     * Get Warehouse From Id
     * @param $warehouseId
     * @return mixed
     */
    public function getWarehouseForDisplay($warehouseId);

    /**
     * Get Warehouse List of Location
     * @param $warehouseId
     * @return mixed
     */
    public function getWarehouseLocations($warehouseId);


    /**
     * Save a Warehouse with an Address attached.
     * @param array $customer
     * @param array $address
     * @return mixed
     */
    public function saveWarehouseWithLocation(array $customer, array $location);

    /**
     * Save a new Warehouse with no address
     * @param array $customer
     * @return mixed
     */
    public function saveWarehouse(array $warehouse);

    /**
     * Save an existing customer address
     * @param array $customer
     * @return mixed
     */
    public function saveWarehouseLocation(array $customer);

    /**
     * Used to soft delete a customer from database
     * @param $warehouseId
     * @param bool $purge
     * @return mixed
     */
    public function removeWarehouse($warehouseId, $purge = false);

    /**
     * Removes Warehouse address
     * @param $locationId
     * @param bool $purge
     * @return mixed
     */
    public function removeWarehouseLocation($locationId, $purge = false);

    /**
     * Update an existing Warehouse details
     * @param $warehouseId
     * @param array $customer
     * @return mixed
     */
    public function updateWarehouse($warehouseId, array $customer);

    /**
     * Update an Existing Warehouse Address
     * @param $locationId
     * @param array $address
     * @return mixed
     */
    public function updateWarehouseLocation($locationId, array $location);

    /** Warehouse Functions to get Invoices etc */

    /**
     * Get Warehouse Utilization
     * @return mixed
     */
    public function getWarehouseUtilization();


}