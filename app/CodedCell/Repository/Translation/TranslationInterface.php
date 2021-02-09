<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 27/Jun/2017
 * Time: 12:23 PM
 */

namespace CodedCell\Repository\Translation;


interface TranslationInterface
{
    /**
     * Get all Translation with No Pagination
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'));

    /**
     * Get all Translation with Pagination
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*'));

    /**
     * Save Translation
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Save Translation
     * @param array $data
     * @return mixed
     */
    public function createRelation(array $data, $relation);

    /**
     * Update Translation
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * Delete Translation
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find Translation
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * Find Translation by specific column
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));

}