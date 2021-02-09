<?php


namespace CodedCell\Repository\Category;

interface CategoryInterface
{
    /**
     * Get all Product Category with No Pagination
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'));

    /**
     * Get all Product Category with Pagination
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'));

    public function paginateDetails($id, $perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'));

    /**
     * Save Product Category
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Save Product Category
     * @param array $data
     * @return mixed
     */
    public function createRelation(array $data, $relation);

    /**
     * Update Product Category
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * Delete Product Category
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find Product Category
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * Find Product Category by specific column
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));

}