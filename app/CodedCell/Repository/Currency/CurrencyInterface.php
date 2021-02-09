<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 7/5/2016
 * Time: 05:55
 */

namespace CodedCell\Repository\Currency;


interface CurrencyInterface
{
    /**
     * Get all Currency with No Pagination
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'));

    /**
     * Get all Currency with Pagination
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*'));

    /**
     * Save Currency
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Save Currency
     * @param array $data
     * @return mixed
     */
    public function createRelation(array $data, $relation);

    /**
     * Update Currency
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * Delete Currency
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find Currency
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * Find Currency by specific column
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));

    /**
     * Get Current Currency
     * @param $date
     * @return mixed
     *
     */
    public function getCurrentCurrency($date,$currency);

}