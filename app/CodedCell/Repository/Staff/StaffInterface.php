<?php


namespace CodedCell\Repository\Staff;


interface StaffInterface
{

    public function all(array $params);

    public function allReport();

    public function staffList();

    public function createStaff($user);

    public function updateStaff($id, $user);

    public function getStaffById($id);

    public function getStaffJson();

    public function deleteStaff($id);

    public function restoreStaff($id);

    public function allDeleted();

    public function staffCount();

    public function deletedStaffCount();
}