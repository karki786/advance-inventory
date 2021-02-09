<?php namespace CodedCell\Repository\Supplier;

interface SupplierInterface
{
    public function all(array $params);

    public function allSuppliersReport();

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'));

    public function allDeletedSuppliersReport();

    public function supplierList();

    public function suppliersReportAmount();

    public function createSupplier($supplier);

    public function deleteSupplier($id);

    public function restoreSupplier($id);

    public function getSuppliersCount();

    public function getDeletedSuppliersCount();

    public function getDeletedSuppliers();

    public function getSupplierById($id);

    public function updateSupplier($id, $newSupplier);

    /**
     * Get Supplier Deliveries Graph
     * @param $supplierId
     * @param string $perPeriod
     * @return mixed
     */
    public function getSupplierDeliveryGraph($supplierId, $perPeriod = "MONTH");

    /**
     * Get Supplier Deliveries Graph
     * @param $supplierId
     * @return mixed
     */
    public function getSupplierDeliveryTimeGraph($supplierId);

    /**
     * Get Supplier Lpos.
     * @param $supplierId
     * @return mixed
     */
    public function getSupplierLpos($supplierId);

}
