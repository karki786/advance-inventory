<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 1/7/2017
 * Time: 19:13
 */

namespace CodedCell\Repository\Receipt;


interface ReceiptInterface
{
    /**
     * Get all Receipt with No Pagination
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'));

    /**
     * Get all Receipt with Pagination
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*'));

    /**
     * Save Receipt
     * @param array $data
     * @return mixed
     */
    public function create(array $data, $items);

    /**
     * Save Receipt
     * @param array $data
     * @return mixed
     */
    public function createRelation(array $data, $relation);

    /**
     * Update Receipt
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $items, $id);

    /**
     * Delete Receipt
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find Receipt
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * Find Receipt by specific column
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));


}