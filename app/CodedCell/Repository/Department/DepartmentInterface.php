<?php namespace CodedCell\Repository\Department;

interface DepartmentInterface
{
    public function all(array $params);

    public function addDepartment($Department);

    public function getDepartmentByID($id);

    public function updateDepartment($id, $department);

    public function deleteDepartment($id);

    public function getDepartmentAmount();

    public function departmentList();

    public function getDepartmentChart();

    public function getDepartmentCount();
    public function getDepartmentReport();
}