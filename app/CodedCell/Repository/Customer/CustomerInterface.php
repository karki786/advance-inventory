<?php


namespace CodedCell\Repository\Customer;


interface CustomerInterface
{
    /**
     * Get all Customer with No Pagination
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'), $scope = null);

    /**
     * Get all Customer with Pagination
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'));

    /**
     * Save Customer
     * @param array $data
     * @return mixed
     */
    public function create(array $data, $contacts);

    /**
     * Save Customer
     * @param array $data
     * @return mixed
     */
    public function createRelation(array $data, $relation);

    /**
     * Update Customer
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, array $items, $id);

    /**
     * Delete Customer
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find Customer
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * Find Customer by specific column
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));

    /**
     *Get Company Contacts
     * @param $companyId
     * @return mixed
     */
    public function getContacts($companyId);

    /**
     * Check Customer Credit
     * @param $id
     * @return mixed
     */
    public function checkCustomerCredit($id);

    public function getPendingPayments($id);

}
