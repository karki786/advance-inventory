<?php namespace CodedCell\Repository\SalesOrder;

use App\Company;
use App\SalesOrder;
use App\SalesOrderItem;
use Auth;
use Carbon\Carbon;
use DB;

class SalesOrderEntity implements SalesOrderInterface
{

    public function all($columns = array('*'), $scope = null)
    {
        $salesOrder = new SalesOrder();
        if (count($scope) != 0) {
            $salesOrder = call_user_func(array($salesOrder, $scope));
        }
        return $salesOrder->with('items')->orderBy('id', 'desc')->get($columns);
    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $sales = SalesOrder::with('items');
        if ($filter != null) {
            $sales = $sales->where('orderNo', 'LIKE', '%' . $filter . '%')
                ->orwhere('customerText', 'LIKE', '%' . $filter . '%')
                ->orwhere('salesPersonText', 'LIKE', '%' . $filter . '%')
                ->orwhere('currencyTypeText', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            $sales = $sales->$scope();
        }
        if ($paginate) {
            return $sales->paginate($perPage, $columns);
        } else {
            return $sales->get();
        }
    }

    public function groupByDelivery()
    {
        $salesOrder = new SalesOrder();
        return $salesOrder->with('shipping')->groupBy('shippingZone')->where('delivery', '=', 1)->get();
    }

    public function showDeliveries($shippingZone)
    {
        return SalesOrder::with('items')->where('shippingZone', '=', $shippingZone)->get();
    }

    public function showDeliveriesForSelect($shippingZone)
    {
        return SalesOrder::select('id', 'orderNo as text')->where('shippingZone', '=', $shippingZone)->whereNotNull('shippingZone')->get();
    }


    public function allCombined($id)
    {
        return SalesOrderItem::select('discount', 'salesOrderId', 'productId', 'productDescription', DB::raw('sum(quantity) as qty'), 'convertedPrice', 'tax', 'total')
            ->where('salesOrderId', $id)
            ->groupBy('discount', 'salesOrderId', 'productId', 'productDescription', 'convertedPrice', 'tax', 'total')
            ->get();
    }


    private function buildSalesOrderNumber($lpoString, $model)
    {
        $vars = array(
            '{$quoteNumber}' => $model->id,
            '{$date}' => Carbon::now()->day,
            '{$month}' => Carbon::now()->month,
            '{$year}' => Carbon::now()->year,
        );

        return strtr($lpoString, $vars);
    }

    public function create(array $data, $items)
    {
        $salesOrder = SalesOrder::create($data);
        $this->createRelation($items, $salesOrder);
        if (!isset($data['companyId'])) {
            $salesFormat = Company::find(Auth::user()->companyId)->salesOrderNumberingFormat;
        } else {
            $salesFormat = Company::withoutGlobalScopes()->find($data['companyId'])->salesOrderNumberingFormat;
        }
        $lpoString = $this->buildSalesOrderNumber($salesFormat, $salesOrder);
        $salesOrder->update(['orderNo' => $lpoString]);
        return $salesOrder;
    }

    private function buildRelationShip($arrayItems)
    {
        $empty = [];
        foreach ($arrayItems as $array) {
            $array->productId = $array->prod_id;
            $array = array_except((array)$array, ['prod_id', 'price', 'has_error', 'error']);
            array_push($empty, new SalesOrderItem((array)$array));
        }
        return $empty;
    }

    public function createRelation(array $data, $relation)
    {
        $data = $this->buildRelationShip($data);
        return $relation->items()->saveMany($data);
    }

    public function update(array $data, $id)
    {
        $salesOrder = SalesOrder::find($id);
        if (Auth::user()->can('update', $salesOrder)) {
            $salesOrder->update($data);
        }
    }

    public function updateItem(array $data, $id)
    {
        return SalesOrderItem::findOrFail($id)->update($data);
    }


    public function delete($id)
    {
        $salesOrder = SalesOrder::findOrFail($id);
        if (Auth::user()->can('delete', $salesOrder)) {
            return SalesOrder::destroy($id);
        }

    }

    public function find($id, $columns = array('*'))
    {
        return SalesOrder::with('items')->findOrFail($id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return SalesOrder::where($field, '=', $value)->firstOrFail($columns);
    }

    public function getSubZoneSalesOrder(array $items)
    {
        return DB::table('sales_order_items')
            ->join('sales_orders', 'sales_orders.id', '=', 'sales_order_items.salesOrderId')
            ->join('customers', 'customers.id', '=', 'sales_orders.customerId')
            ->join('shipping_sub_zones', 'shipping_sub_zones.id', '=', 'customers.shippingSubZone')
            ->select('sales_order_items.productDescription', 'shipping_sub_zones.shippingZone', 'customers.shippingSubZone', DB::raw('sum(sales_order_items.quantity) as count'))
            ->groupBy('customers.shippingSubZone', 'shipping_sub_zones.shippingZone', 'sales_order_items.productDescription')
            ->whereIn('sales_orders.id', $items)
            ->get();
    }


}