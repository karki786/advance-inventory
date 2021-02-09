<?php


namespace CodedCell\Repository\SalesOrder;


interface SalesOrderInterface
{
    /**
     * Get all Sales Order with No Pagination
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'), $scope = null);

    public function groupByDelivery();

    public function showDeliveries($shippingZone);
    
    public function showDeliveriesForSelect($shippingZone);

    public function allCombined($id);

    /**
     * Get all Sales Order with Pagination
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $filter = null, $scope = null, $columns = array('*'));

    /**
     * Save Sales Order
     * @param array $data
     * @return mixed
     */
    public function create(array $data, $items);

    /**
     * Save Sales Order
     * @param array $data
     * @return mixed
     */
    public function createRelation(array $data, $relation);

    /**
     * Update Sales Order
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data,  $id);
    public function updateItem(array $data, $id);

    /**
     * Delete Sales Order
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find Sales Order
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * Find Sales Order by specific column
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));

    public function getSubZoneSalesOrder(array $items);

}