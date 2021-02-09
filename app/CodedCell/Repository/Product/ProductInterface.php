<?php namespace CodedCell\Repository\Product;

interface ProductInterface
{
    /**
     * Get all Product with No Pagination
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'));

    /**
     * Get all Product with Pagination
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'));

    /**
     * Save Product
     * @param array $data
     * @return mixed
     */
    public function create(array $data, $locations);

    /**
     * Save Product
     * @param array $data
     * @return mixed
     */
    public function createRelation(array $data, $relation);

    /**
     * Update Product
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $locations, $id);

    /**
     * Delete Product
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find Product
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * Find Product by specific column
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));

    /**
     * Get Warehouse Locations for Grid
     * @return array|static[]
     */
    public function getWarehouseLocationsForGrid();

    public function getProductForDataGrid();
    public function getProductForRestock();

    public function getProductForAjaxGrid($id, $type);


}
