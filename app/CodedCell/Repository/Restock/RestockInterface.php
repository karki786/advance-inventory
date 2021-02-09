<?php namespace CodedCell\Repository\Restock;

interface RestockInterface
{
    public function all(array $params);

    public function allFrom($date);

    public function allDeletedFrom($date);

    public function restock($product);

    public function delete($id, $product);

    public function getById($id);

    public function updateRestock($id, $product);

    public function getRestocksCount();

    public function getDeletedRestocksCount();

    public function getDeleted();

    public function getDefective();

    public function restoreRestock($id);

    public function getCost($days);

    /**
     * Get Daily Restock of Goods
     * @return mixed
     */
    public function getDailyRestockGraph();

    public function findBy($field, $equal, $value);
}
