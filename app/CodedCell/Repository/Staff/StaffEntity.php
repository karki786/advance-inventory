<?php namespace CodedCell\Repository\Staff;

use App\Staff;
use CodedCell\Repository\Settings\SettingsInterface;
use DB;
use Auth;
use Schema;

class StaffEntity implements StaffInterface
{

    public function __construct(SettingsInterface $setting)
    {
        $this->setting = $setting;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function all(array $params)
    {
        $staff = new Staff();
        if (isset($params['deleted'])) {
            $staff = $staff->onlyTrashed();
        }
        return $staff->with('department')
            ->leftJoin('departments', 'staff.departmentId', '=', 'departments.id')
            ->select('staff.*')
            ->where('staff.companyId', '=', Auth::user()->companyId)
            ->get();
    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $staff = Staff::with([
                'department',

            ]
        );
        if ($filter != null) {
            $staff = $staff->where('name', 'LIKE', '%' . $filter . '%')
                ->orwhere('email', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            if (is_array($scope)) {
                $parameter = $scope[1];
                $scope = $scope[0];
                $staff = $staff->$scope($parameter);
            } else {
                $staff = $staff->$scope();
            }
        }

        if ($paginate) {
            return $staff->paginate($perPage, $columns);
        } else {
            return $staff->get();
        }
    }


    /**
     * @return mixed
     * All staff report for excel
     */
    public function allReport()
    {
        return Staff::all();
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
                $query->orWhere('staff.' . $column, 'LIKE', "%{$search}%");
            }
        });
        return $item;
    }

    /**
     * @return mixed
     */
    public function staffList()
    {
        return DB::table('staff')
            ->join('departments', 'departments.id', '=', 'staff.departmentId')
            ->where('staff.companyId', '=', Auth::user()->companyId)
            ->select('staff.id as id', DB::raw('concat(staff.name,"(",departments.name,")") as name'))->pluck('name', 'id');
    }

    /**
     * @param $user
     * @return static
     */
    public function createStaff($user)
    {
        return Staff::create($user);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getStaffById($id)
    {
        return Staff::find($id);
    }

    public function getStaffJson()
    {
        return DB::table('staff')
            ->join('departments', 'departments.id', '=', 'staff.departmentId')
            ->where('staff.companyId', '=', Auth::user()->companyId)
            ->select('staff.id as id', DB::raw('concat(staff.name,"(",departments.name,")") as text'))->get();
    }


    /**
     * @param $id
     * @param $user
     * @return mixed
     */
    public function updateStaff($id, $user)
    {
        $staff = Staff::findOrFail($id);
        if (Auth::user()->can('update', $staff)) {
            return $staff->update($user);
        }

    }

    /**
     * @param $id
     * @return int
     */
    public function deleteStaff($id)
    {
        $staff = Staff::findOrFail($id);
        if (Auth::user()->can('delete', $staff)) {
            return Staff::destroy($id);
        }

    }

    /**
     * @param $id
     * @return mixed
     */
    public function restoreStaff($id)
    {
        return Staff::withTrashed()->where('id', $id)->restore();
    }

    /**
     * @return mixed
     */
    public function allDeleted()
    {
        $pagination = $this->setting->getSettings()->paginationDefault;
        return Staff::onlyTrashed()->where('companyId', '=', Auth::user()->companyId)->paginate($pagination)->setPath('');
    }

    /**
     * @return mixed
     */
    public function staffCount()
    {
        return Staff::where('companyId', '=', Auth::user()->companyId)->get()->count();
    }

    /**
     * @return mixed
     */
    public function deletedStaffCount()
    {
        return User::where('companyId', '=', Auth::user()->companyId)->onlyTrashed()->count();
    }
}