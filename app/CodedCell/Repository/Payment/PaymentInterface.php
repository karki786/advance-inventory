<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 7/31/2016
 * Time: 15:51
 */

namespace CodedCell\Repository\Payment;

interface PaymentInterface
{
    /**
     * Get all Payment with No Pagination
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'),$scope = null);

    /**
     * Get all Payment with Pagination
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*'));

    /**
     * Save Payment
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Save Payment
     * @param array $data
     * @return mixed
     */
    public function createGroup(array $data);


    /**
     * Save Payment
     * @param array $data
     * @return mixed
     */
    public function createRelation(array $data, $relation);

    /**
     * Update Payment
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * Delete Payment
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find Payment
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * Find Payment by specific column
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));

}