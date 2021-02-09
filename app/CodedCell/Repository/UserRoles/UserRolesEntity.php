<?php namespace CodedCell\Repository\UserRoles;

use App\Role;

/**
 * Class UserRolesEntity
 * @package CodedCell\Repository\UserRoles
 */
class UserRolesEntity implements UserRolesInterface
{

    public function all($columns = array('*'))
    {
        return Role::with('permissions')->get($columns);
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        return Role::with('permissions')->paginate($perPage, $columns);
    }

    public function create(array $data)
    {
        return Role::create($data);
    }

    private function buildRelationShip($arrayItems)
    {
        $empty = [];
        foreach ($arrayItems as $array) {
            array_push($empty, new Role((array)$array));
        }
        return $empty;
    }

    public function createRelation(array $data, $relation)
    {
        $data = $this->buildRelationShip($data);
        return $relation->permissions()->saveMany($data);
    }

    public function update(array $data, $id)
    {
        return Role::find($id)->update($data);
    }

    public function delete($id)
    {
        return Role::destroy($id);
    }

    public function find($id, $columns = array('*'))
    {
        return Role::with('permissions')->find($id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return Role::where($field, '=', $value)->first($columns);
    }



    /**
     * @return mixed
     */
    public function roleList()
    {
        return Role::pluck('name', 'id');
    }

    /**
     * @return mixed
     */
    public function rolesCount()
    {
        return Role::all()->count();
    }
}
