<?php namespace CodedCell\Repository\User;

interface UserInterface
{
    public function all(array $params);

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'));

    public function allReport();

    public function usersList();

    public function createUser($user);

    public function updateUser($id, $user);

    public function getById($id);

    public function deleteUser($id);

    public function restoreUser($id);

    public function allDeleted();

    public function userCount();

    public function deletedCount();

    public function getCompanyMembers();

    public function getUsersForLpoGenerate();
}
