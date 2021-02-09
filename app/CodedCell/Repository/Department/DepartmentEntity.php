<?php namespace CodedCell\Repository\Department;

use App\Department;
use CodedCell\Repository\Settings\SettingsInterface;
use DB;
use Auth;
use Schema;

/**
 * Class NewDepartment
 * @package CodedCell\Repository\Department
 * Department Repository
 */
class DepartmentEntity implements DepartmentInterface
{
    public function __construct(SettingsInterface $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Gets all departments from db
     * @param array $params
     * @return mixed
     */
    public function all(array $params)
    {

        $department = Department::with('dispatches')->get();
        return $department;

    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $department = Department::with([
                'dispatches',
            ]
        );
        if ($filter != null) {
            $department = $department->where('name', 'LIKE', '%' . $filter . '%')
                ->orwhere('email', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            if (is_array($scope)) {
                $parameter = $scope[1];
                $scope = $scope[0];
                $department = $department->$scope($parameter);
            } else {
                $department = $department->$scope();
            }
        }

        if ($paginate) {
            return $department->paginate($perPage, $columns);
        } else {
            return $department->get();
        }
    }

    /**
     * @param $item
     * @param $search
     * @param $table
     * @return mixed
     * Used to search for an department
     */
    public function search($item, $search, $table)
    {
        $columns = Schema::getColumnListing($table);
        unset($columns[0]);
        $first = $columns[1];
        $item = $item->where(function ($query) use ($search, $columns) {
            foreach ($columns as $column) {
                $query->orWhere('departments.' . $column, 'LIKE', "%{$search}%");
            }
        });
        return $item;
    }

    /**
     * Returns the number of departments
     * @return integer
     */
    public function getDepartmentCount()
    {
        return Department::all()->count();
    }

    /**
     * Adds Department to DB
     * @param $Department
     * @return static
     */
    public function addDepartment($Department)
    {
        return Department::create($Department);
    }

    /**
     * Gets Department by ID
     * @param $id
     * @return mixed
     */
    public function getDepartmentByID($id)
    {
        return Department::findOrFail($id);
    }

    /**
     * @param $id
     * @param $department
     * @return mixed
     * Updates an existing department
     */
    public function updateDepartment($id, $department)
    {
        $dep= Department::findOrFail($id);
        if (Auth::user()->can('update', $dep)) {
            return $dep->update($department);
        }

    }

    /**
     * @param $id
     * @return int
     * Deletes an existing department
     */
    public function deleteDepartment($id)
    {
        $department = Department::findOrFail($id);
        if (Auth::user()->can('delete', $department)) {
            return Department::destroy($id);
        }

    }

    /**
     * @return mixed
     * Gets amount a department has used so far
     */
    public function getDepartmentAmount()
    {
        $x = array(
            'departments.name',
            DB::raw('sum(dispatches.amount)as dispatchcount'),
            DB::raw('MONTH(dispatches.created_at) month')
        );
        return Department::leftJoin('dispatches', 'dispatches.departmentId', '=', 'departments.id')
            ->select($x)
            // ->select($x)
            //   ->groupBy('products.productName', DB::raw('MONTH(dispatches.created_at)'))
            ->orderBy('month')
            ->get();

    }

    /**
     * @return mixed
     * Returns department list for use in a select2
     */
    public function departmentList()
    {
        return Department::pluck('name', 'id');
    }

    /**
     * @return mixed
     * Returns JSON data for use in chart
     */
    public function getDepartmentChart()
    {
        return $department = Department::leftJoin('dispatches', 'departments.id', '=', 'dispatches.departmentId')
            ->selectRaw('departments.name , count(dispatches.id) as dispatchcount, sum(dispatches.totalCost) as dispatchsum')
            ->groupBy('departments.id')
            ->get();

    }

    /**
     * @return mixed
     * Returns Department report for excel and csv
     */
    public function getDepartmentReport()
    {
        return Department::leftJoin('dispatches', 'departments.id', '=', 'dispatches.departmentId')
            ->selectRaw('departments.* , count(dispatches.id) as dispatchcount, sum(dispatches.totalCost) as dispatchsum')
            ->groupBy('departments.id')
            ->get();
    }
}
