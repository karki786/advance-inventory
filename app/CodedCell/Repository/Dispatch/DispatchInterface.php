<?php namespace CodedCell\Repository\Dispatch;

/**
 * Interface DispatchInterface
 * @package CodedCell\Repository\Dispatch
 */
interface DispatchInterface
{
    public function all(array $params);

    public function allFrom($date);

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'));

    public function allDeletedFrom($date);

    public function dispatch($product);

    public function delete($id);

    public function getById($id);

    public function updateDispatch($id, $product);

    public function getDeletedDispatch();

    public function restoreDispatch($id);

    public function getDispatchCount();

    public function getDeletedCount();

    public function getDailyDispatchReport();

    public function getMonthlyDispatchReport();

    public function getDefective();

    public function getCost();

    /**
     * Get Dispatch By Product
     * @param $productId
     * @return mixed
     */
    public function getDispatchByProduct($productId);

    public function findBy($field, $equal, $value);
}
