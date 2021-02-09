<?php namespace CodedCell\Repository\UserRoles;

interface UserRolesInterface
{


    public function roleList();

    public function rolesCount();

    /**
     * Get all Role with No Pagination
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'));

    /**
     * Get all Role with Pagination
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*'));

    /**
     * Save Role
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Save Role
     * @param array $data
     * @return mixed
     */
    public function createRelation(array $data, $relation);

    /**
     * Update Role
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * Delete Role
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find Role
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * Find Role by specific column
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));

}
