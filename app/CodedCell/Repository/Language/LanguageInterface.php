<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 27/Jun/2017
 * Time: 11:46 AM
 */

namespace CodedCell\Repository\Language;


interface LanguageInterface
{
    /**
     * Get all Language with No Pagination
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'));

    /**
     * Get all Language with Pagination
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'));


    /**
     * Save Language
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Save Language
     * @param array $data
     * @return mixed
     */
    public function createRelation(array $data, $relation);

    /**
     * Update Language
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * Delete Language
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find Language
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * Find Language by specific column
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));

}