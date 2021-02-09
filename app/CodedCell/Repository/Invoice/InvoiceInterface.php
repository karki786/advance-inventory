<?php


namespace CodedCell\Repository\Invoice;


interface InvoiceInterface
{
    /**
     * Get all Invoices with No Pagination
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'), $scope = null);

    public function allCombined($id);
    
    /**
     * Get all Invoices with Pagination
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $filter = null, $scope = null, $columns = array('*'));

    /**
     * Save Invoices
     * @param array $data
     * @return mixed
     */
    public function create(array $data, $items);



    /**
     * Save Invoices
     * @param array $data
     * @return mixed
     */
    public function createRelation(array $data, $relation);

    /**
     * Update Invoices
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * Delete Invoices
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find Invoices
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * Find Invoices by specific column
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));

}