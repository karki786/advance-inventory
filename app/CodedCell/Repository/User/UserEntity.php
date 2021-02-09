<?php namespace CodedCell\Repository\User;

use App\Helper;
use App\User;
use Auth;
use CodedCell\Repository\Settings\SettingsInterface;
use Schema;
use DB;

/**
 * Class StockUsers
 * @package CodedCell\Repository\User
 */
class UserEntity implements UserInterface
{
    public function __construct(SettingsInterface $setting)
    {
        $this->setting = $setting;
    }

    public function getCompanyMembers()
    {
        if (env('LINKCOMPANYBYUSERNAME') == true) {
            return User::whereName(Auth::user()->name)->where('id', '!=', Auth::user()->id)->pluck('name', 'id');
        }
        return User::whereCompanyid(Helper::getUser()->companyId)->pluck('name', 'id');

    }

    /**
     * @param array $params
     * @return mixed
     */
    public function all(array $params)
    {
        return User::with('department')
            ->with('role')
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->leftJoin('departments', 'users.departmentId', '=', 'departments.id')
            ->select('users.*')
            ->where('users.companyId', '=', Helper::getUser()->companyId)
            ->get();
    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $user = User::with([
                'department',

            ]
        );
        if ($filter != null) {
            $user = $user->where('name', 'LIKE', '%' . $filter . '%')
                ->orwhere('email', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            if (is_array($scope)) {
                $parameter = $scope[1];
                $scope = $scope[0];
                $user = $user->$scope($parameter);
            } else {
                $user = $user->$scope();
            }
        }

        if ($paginate) {
            return $user->paginate($perPage, $columns);
        } else {
            return $user->get();
        }
    }

    /**
     * @return mixed
     * All users report for excel
     */
    public function allReport()
    {
        return User::where('companyId', '=', Helper::getUser()->companyId)->get();
    }

    /**
     * @param $item
     * @param $search
     * @param $table
     * @return mixed
     */
    public function search($item, $search, $table)
    {
        $columns = Schema::getColumnListing($table);
        unset($columns[0]);
        $first = $columns[1];
        $item = $item->where(function ($query) use ($search, $columns) {
            foreach ($columns as $column) {
                $query->orWhere('users.' . $column, 'LIKE', "%{$search}%");
            }
        });
        return $item;
    }

    /**
     * @return mixed
     */
    public function usersList()
    {
        return User::where('companyId', '=', Helper::getUser()->companyId)->pluck('name', 'id');
    }

    /**
     * @param $user
     * @return static
     */
    public function createUser($user)
    {
        return User::create($user);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return User::where('companyId', '=', Helper::getUser()->companyId)->findOrFail($id);
    }

    /**
     * @param $id
     * @param $user
     * @return mixed
     */
    public function updateUser($id, $user)
    {
        $usr = User::findOrFail($id);
        if (Auth::user()->can('update', $usr)) {
            return $usr->update($user);
        }

    }

    /**
     * @param $id
     * @return int
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if (Auth::user()->can('delete', $user)) {
            return User::destroy($id);
        }

    }

    /**
     * @param $id
     * @return mixed
     */
    public function restoreUser($id)
    {
        return User::withTrashed()->where('id', $id)->restore();
    }

    /**
     * @return mixed
     */
    public function allDeleted()
    {
        return User::where('companyId', '=', Helper::getUser()->companyId)->onlyTrashed()->get();
    }

    /**
     * @return mixed
     */
    public function userCount()
    {
        return User::where('companyId', '=', Helper::getUser()->companyId)->get()->count();
    }

    /**
     * @return mixed
     */
    public function deletedCount()
    {
        return User::where('companyId', '=', Helper::getUser()->companyId)->onlyTrashed()->count();
    }

    public function getUsersForLpoGenerate()
    {
        return DB::table('users')
            ->select('id', 'companyId')
            ->groupBy('companyId')
            ->get();
    }


}
