<?php

namespace CodedCell\Repository\PurchaseOrder;


interface PurchaseOrderInterface
{
    /**
     * Get all PurchaseOrder with No Pagination
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'));

    /**
     * Get all PurchaseOrder with Pagination
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'));

    /**
     * Save PurchaseOrder
     * @param array $data
     * @return mixed
     */
    public function create(array $data, $relation);

    /**
     * Save PurchaseOrder
     * @param array $data
     * @return mixed
     */
    public function createRelation(array $data, $relation);

    /**
     * Update PurchaseOrder
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * Delete PurchaseOrder
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find PurchaseOrder
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * Find PurchaseOrder by specific column
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));

    /**
     * Restock from purchase Order
     * @param $product
     * @param $supplierId
     */
    public function restockFromPurchaseOrder($product, $supplierId);

}